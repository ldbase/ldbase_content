(function ($, Drupal) {
  Drupal.behaviors.d3_content_count_src = {
    attach: function (context, settings) {
      $(document, context).once('d3_content_count_src').each(function () {

        // set the dimensions and margins of the graph
        var margin = { top: 10, right: 20, bottom: 50, left: 75 },
          width = 400 - margin.left - margin.right,
          height = 300 - margin.top - margin.bottom;

        // set the ranges
        var y = d3.scaleBand()
          .range([height, 0])
          .padding(0.1);

        var x = d3.scaleLinear()
          .range([0, width]);

        // append the svg object to the body of the page
        // append a 'group' element to 'svg'
        // moves the 'group' element to the top left margin
        var svg = d3.select("div#block-ldbasecontentcountd3visualization div#ldbase-d3-visualization-container")
          .append("svg")
          .attr("width", width + margin.left + margin.right)
          .attr("height", height + margin.top + margin.bottom)
          .append("g")
          .attr("transform",
            "translate(" + margin.left + "," + margin.top + ")");

        d3.json("content-counts-api", function(error, data) {
          if (error) throw error;

          // format the data
          data.forEach(function (d) {
            d.value = +d.value;
            d.formatted_name = (d.name != 'Code') ? d.name + 's' : d.name;
          });

          // Scale the range of the data in the domains
          x.domain([0, d3.max(data, function (d) { return d.value; })])
          y.domain(data.map(function (d) { return d.formatted_name; }));

          // append the rectangles for the bar chart
          svg.selectAll(".bar")
            .data(data)
            .enter().append('svg:a')
            .attr("class", "link")
            .attr("xlink:href", function (d) { return "/" + d.formatted_name.toLowerCase() })
            .append("rect")
            .attr("class", function (d) { return d.name + "-fill"; })
            .attr("width", function (d) { return x(d.value); })
            .attr("y", function (d) { return y(d.formatted_name); })
            .attr("height", y.bandwidth())
            .append("title").text( function (d) { return d.value + ' ' + d.formatted_name; });

          // add the x Axis
          svg.append("g")
            .attr("transform", "translate(0," + height + ")")
            .call(d3.axisBottom(x));

          // add the y Axis
          svg.append("g")
            .call(d3.axisLeft(y))
            .selectAll(".tick text")
            .attr("font-size", "16")
            .attr("fill", "#671e30")
            .attr("text-decoration", "underline")
            .style("cursor","pointer")
            .on("click", function (d) { window.location.href = "/" + d.toLowerCase();});

        // end d3.json
        });

      // end .once()
      });
    }
  };
})(jQuery, Drupal);
