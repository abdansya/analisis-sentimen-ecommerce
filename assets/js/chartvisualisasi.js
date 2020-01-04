$(document).ready(function(){
  var myConfig = {
    type: "area",
    "title":{
      "text":"Analisis 1 pekan"
    },
    "legend":{
      "background-color":"#ffe6e6",
      "border-width":2,
      "border-color":"red",
      "border-radius":"5px",
      "padding":"10%",
      "layout":"2x3",
      "x":"34%",
      "y":"10%",
    },
    plotarea: {
      /*Add an adjust-layout attribute for automatic margin adjustment*/
      "margin-top":"25%",
      "margin-right":"5%",
      "margin-left":"5%"
    },
    scaleX: {
      label:{  /*Add a scale title with a label object*/
        text:"Tanggal crawling",
      },
      /*Add your scale labels with a labels array*/
      labels: tanggal
    },
    series: [
      {
        values: lazada_p,
        text: "Lazada Positif"
      },
      {
        values: bukalapak_p,
        text: "Bukalapak Positif"

      },
      {
        values: tokopedia_p,
        text: "Tokopedia Positif"
      },
      {
        values: lazada_n,
        text: "Lazada Negatif"
      },
      {
        values: bukalapak_n,
        text: "Bukalapak Negatif"
      },
      {
        values: tokopedia_n,
        text: "Tokopedia Negatif"
      }
    ]
  };

  zingchart.render({
    id : 'chartVisual',
    data : myConfig,
    height: "100%",
    width: "100%"
  });

});
