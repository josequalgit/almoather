<img src="" id="chart1" alt="">
    
   

    <script>
        var options = {
            series: [{
            data: [21, 22, 10, 28, 16, 21, 13, 30]
          }],
          chart: {
              height: 350,
              type: 'bar',
              animations: {
                  enabled: false
              },
            
          },
          plotOptions: {
            bar: {
              columnWidth: '45%',
              distributed: true,
            }
          },
          dataLabels: {
            enabled: false
          },
          
          legend: {
            show: false
          },
          xaxis: {
            categories: [
              ['John', 'Doe'],
              ['Joe', 'Smith'],
              ['Jake', 'Williams'],
              'Amber',
              ['Peter', 'Brown'],
              ['Mary', 'Evans'],
              ['David', 'Wilson'],
              ['Lily', 'Roberts'], 
            ],
            labels: {
              style: {
                fontSize: '12px'
              }
            }
          }
          };
  
          var chart = new ApexCharts(document.querySelector('#chart'), options);
          chart.render().then(() => {
              chart.dataURI().then(({ imgURI, blob }) => { //Here shows error
                  imgURI = imgURI.replace('image/png','image/jpg')
                  $('#chart1').attr('src',imgURI);
                  
              })
          })
    </script>
</body>

</html>
