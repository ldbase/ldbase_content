(function ($, Drupal) {
  Drupal.behaviors.d3_contributions_src = {
    attach: function (context, settings) {
      $(document, context).once('d3_contributions_src').each(function () {

      var height = 600;
      var width = 800;

      var svg = d3.select('div#block-ldbasecontributionsd3visualization div#ldbase-d3-visualization-container')
        .append('svg')
        .attr("viewBox", [-width / 2, -height /2 , width, height]);

      var simulation = d3.forceSimulation()
        .force("link", d3.forceLink().id(d => d.id))
        .force("charge", d3.forceManyBody().strength(-75))
        .force("x", d3.forceX())
        .force("y", d3.forceY());

      d3.queue()
        .defer(d3.json, 'persons/persons-api')
        .defer(d3.json, 'persons/contributions-api')
        .await(function(error, nodes, links) {

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
            .enter().append("circle")
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
    });
    }
  };
})(jQuery, Drupal);
