(function ($, Drupal) {
  Drupal.behaviors.d3_contributions_src = {
    attach: function (context, settings) {
      $(document, context).once('d3_contributions_src').each(function () {

      var height = 600;
      var width = 800;

      var svg = d3.select('div#block-ldbasecontributionsd3visualization div#ldbase-d3-visualization-container')
        .append('svg')
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
            .selectAll("circle")
            .data(nodes)
            .enter().append("svg:a")
            .attr("class", "link")
            .attr("xlink:href", function (d) { return d.url })
            .append("circle")
            // make person nodes bigger
            .attr("r", function (d) {return d.group == 'Person'? 7 : 5; })
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
              .attr("cx", function (d) { return d.x; })
              .attr("cy", function (d) { return d.y; });
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

      var ordinal = d3.scaleOrdinal()
        .domain(["Person", "Project", "Dataset", "Document", "Code"])
        .range(["#1f77b4", "#9467bd", "#ff7f0e", "#2ca02c", "#d62728"]);

      svg.append("g")
        .attr("class", "legendOrdinal")
        .attr("transform", "translate(-390,-290)");

      var legendOrdinal = d3.legendColor()
        .shapeWidth(20)
        .shapePadding(10)
        .scale(ordinal);

      svg.select(".legendOrdinal")
        .call(legendOrdinal);

    });
    }
  };
})(jQuery, Drupal);
