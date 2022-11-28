(function ($, Drupal) {
  Drupal.behaviors.d3_contributions_src = {
    attach: function (context, settings) {
      $(document, context).once('d3_contributions_src').each(function () {

      var height = 600;
      var width = 800;

      var svg = d3.select('div#block-ldbasecontributionsd3visualization div#ldbase-d3-visualization-container')
        .append('svg')
        .attr("class","contributionChart")
        .attr("viewBox", [-width / 2, -height /2 , width, height])
        .attr("width", width)
        .attr("height", height)
        .call(d3.zoom().on("zoom", function () {
          svg.attr("transform", d3.event.transform)
        }))
        .append("g");

      var simulation = d3.forceSimulation()
        .force("link", d3.forceLink().id(d => d.id))
        .force("charge", d3.forceManyBody().strength(-75))
        .force("x", d3.forceX())
        .force("y", d3.forceY());

      d3.queue()
        .defer(d3.json, 'persons/persons-api')
        .defer(d3.json, 'persons/contributions-api')
        .await(function(error, nodes, links) {

          // create link url
          nodes.forEach(function (d) {
            d.content_type = (d.group != 'Code') ? d.group.toLowerCase() + 's' : d.group.toLowerCase();
            d.url = d.content_type + "/" + d.uuid;
          });

          var link = svg.append("g")
            .attr("class", "links")
            .selectAll("line")
            .data(links)
            .enter().append("line")
            .attr("stroke", "black")
            .attr("stroke-width", 1);

          var node = svg.append("g")
              .attr("class", "nodes")
            .selectAll(".path")
            .data(nodes)
            .enter().append("svg:a")
            .attr("class", "link")
            .attr("xlink:href", function (d) { return d.url })
            .append("path")
            .attr('d', d3.symbol().type(function (d) {
              if (d.group == 'Person') {
                return d3.symbolCircle;
              } else if (d.group == 'Project') {
                return d3.symbolCross;
              } else if (d.group == 'Dataset') {
                return d3.symbolDiamond;
              } else if (d.group == 'Document') {
                return d3.symbolSquare;
              } else {
                return d3.symbolTriangle;
              }
            }).size(100))
            .attr("class", function (d) { return d.group + "-fill nodes"; })
            .call(d3.drag()
              .on("start", dragstarted)
              .on("drag", dragged)
              .on("end", dragended));

          node.append("title")
            .text(function (d) { return d.title; });

          simulation
            .nodes(nodes)
            .on("tick", ticked);

          simulation.force("link")
            .links(links);


          function ticked() {
            link
              .attr("x1", function (d) { return d.source.x; })
              .attr("y1", function (d) { return d.source.y; })
              .attr("x2", function (d) { return d.target.x; })
              .attr("y2", function (d) { return d.target.y; });

            node
              .attr('transform', function (d) { return 'translate(' + d.x + ',' + d.y + ')'; });
          }
        }
      );

      function dragstarted(d) {
        if (!d3.event.active) simulation.alphaTarget(0.3).restart();
        d.fx = d.x;
        d.fy = d.y;
      }

      function dragged(d) {
        d.fx = d3.event.x;
        d.fy = d3.event.y;
      }

      function dragended(d) {
        if (!d3.event.active) simulation.alphaTarget(0);
        d.fx = null;
        d.fy = null;
      }

        var legendData = [["Person", "#235FA4", "circle"], ["Project", "#FF4242", "cross"], ["Dataset", "#6FDE6E", "diamond"], ["Document", "#A691AE", "square"], ["Code", "#E8F086", "traiangleDown"]];
        var legend = d3.select('div#block-ldbasecontributionsd3visualization div#ldbase-d3-visualization-legend')
        .append("svg")
        .attr("class", "legendOrdinal")
        .attr("height", 150)
        .attr("width", 150)

        var legendRect = legend
          .selectAll('g')
          .data(legendData);

        var legendRectE = legendRect.enter()
          .append("g")
          .attr("transform", function (d, i) {
            return 'translate(20, ' + ((i + 1) * 20) + ')';
          });

        legendRectE
          .append('path')
          .attr('d', d3.symbol().type(function (d, i) {
            if (d[2] === "circle") {
              return d3.symbolCircle;
            } else if (d[2] === "cross") {
              return d3.symbolCross;
            } else if (d[2] === "diamond") {
              return d3.symbolDiamond;
            } else if (d[2] === "square") {
              return d3.symbolSquare;
            } else {
              return d3.symbolTriangle;
            }
          })
            .size(100))
          .style("fill", function (d) {
            return d[1];
          });

        legendRectE
          .append("text")
          .attr("x", 10)
          .attr("y", 5)
          .text(function (d) {
            return d[0];
          });
    });
    }
  };
})(jQuery, Drupal);
