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
    	id : 'myChart',
    	data : myConfig,
    	height: "100%",
    	width: "100%"
    });



// ========================================================================= //

  var myConfigPie = {
   	type: "pie",
    "background-color": "none",
    plot: {
   	  borderColor: "#2B313B",
   	  borderWidth: 5,
   	  // slice: 90,
   	  valueBox: {
   	    placement: 'out',
   	    text: '%t\n%npv%',
   	    fontFamily: "Open Sans"
   	  },
   	  tooltip:{
   	    fontSize: '18',
   	    fontFamily: "Open Sans",
   	    padding: "5 10",
   	    text: "%npv%"
   	  },
   	  animation:{
        effect: 2,
        method: 5,
        speed: 900,
        sequence: 1,
        delay: 3000
      }
   	},
   	title: {
   	  fontColor: "#8e99a9",
   	  text: 'Persentase Sentimen',
   	  align: "left",
   	  offsetX: 10,
   	  fontFamily: "Open Sans",
   	  fontSize: 25
   	},
   	plotarea: {
   	  margin: "20 0 0 0"
   	},
  	series : [
  		{
  			values : [persenlp],
  			text: "Lazada Positif",
  		  backgroundColor: '#FFCB45',
  		},
  		{
  		  values: [persenln],
  		  text: "Lazada Negatif",
  		  backgroundColor: '#FF7965',
  		  detached:true
  		},
  		{
  		  values: [persenbp],
  		  text: 'Bukalapak Positif',
  		  backgroundColor: '#50ADF5',
  		  detached:true
  		},
  		{
  		  text: 'Bukalapak Negatif',
  		  values: [persenbn],
  		  backgroundColor: '#6877e5'
  		},
  		{
  		  text: 'Tokopedia Positif',
  		  values: [persentp],
  		  backgroundColor: '#52fe16'
  		},
  		{
  		  text: 'Tokopedia Negatif',
  		  values: [persentn],
  		  backgroundColor: '#6FB07F'
  		}
  	]
  };

  zingchart.render({
  	id : 'myChartPie',
  	data : myConfigPie,
  	height: '100%',
  	width: '100%'
  });

  // ============================================================================//


  var myConfigAkurasi = {
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
      "layout":"1x6",
      "x":"20%",
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
        values: lazada_n,
        text: "Lazada Negatif"
      },
      {
        values: bukalapak_p,
        text: "Bukalapak Positif"
      },
      {
        values: bukalapak_n,
        text: "Bikalapak Negatif"
      },
      {
        values: tokopedia_p,
        text: "Tokopedia Positif"
      },
      {
        values: tokopedia_n,
        text: "Tokopedia Negatif"
      }
    ]
  };

  zingchart.render({
    id : 'myChartAkurasi',
    data : myConfigAkurasi,
    height: "100%",
    width: "100%"
  });

// ================================================================================= //


  var configGrafikArea = {
    type: "area",
    "title":{
      "text":judulGrafik
    },

    "legend":{
      "background-color":"#ffe6e6",
      "border-width":2,
      "border-color":"red",
      "border-radius":"5px",
      "padding":"10%",
      "layout":"2x3",
      "x":"31%",
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
    id : 'grafikArea',
    data : configGrafikArea,
    height: "100%",
    width: "100%"
  });

// ================================================================================ //

  var configGrafikPie = {
    type: "pie",
    plot: {
      borderColor: "#2B313B",
      borderWidth: 5,
      // slice: 90,
      valueBox: {
        placement: 'out',
        text: '%t\n%npv%',
        fontFamily: "Open Sans"
      },
      tooltip:{
        fontSize: '18',
        fontFamily: "Open Sans",
        padding: "5 10",
        text: "%npv%"
      },
      animation:{
        effect: 2,
        method: 5,
        speed: 900,
        sequence: 1,
        delay: 3000
      }
    },
    title: {
      fontColor: "#004bb9",
      text: 'Persentase Sentimen',
      align: "center",
      offsetX: 10,
      fontFamily: "Open Sans",
      fontSize: 25
    },
    plotarea: {
      margin: "20 0 0 0"
    },
    series : [
      {
        values : [persenlp],
        text: "Lazada Positif",
        backgroundColor: '#FFCB45',
      },
      {
        values: [persenln],
        text: "Lazada Negatif",
        backgroundColor: '#FF7965',
        detached:true
      },
      {
        values: [persenbp],
        text: 'Bukalapak Positif',
        backgroundColor: '#50ADF5',
        detached:true
      },
      {
        text: 'Bukalapak Negatif',
        values: [persenbn],
        backgroundColor: '#6877e5'
      },
      {
        text: 'Tokopedia Positif',
        values: [persentp],
        backgroundColor: '#52fe16'
      },
      {
        text: 'Tokopedia Negatif',
        values: [persentn],
        backgroundColor: '#6FB07F'
      }
    ]
  };

  zingchart.render({
    id : 'grafikPie',
    data : configGrafikPie,
    height: '90%',
    width: '90%'
  });

// ============================================================================= //

  var configAkurasi = {
    "type":"mixed",
    "title":{
      "text":"Akurasi"
    },
    "scale-x":{
      "labels":threshold,
      "label":{
        "text":"Threshold"
      }
    },
    "scale-y":{
      "values":"0:700:100",
      "label":{
        "text":"Waktu (s)"
      }
    },
    "scale-y-2":{
      "values":"0:100:10",
      "label":{
        "text":"Persentase"
      }
    },
    "series":[
      {
        "type":"bar",
        "scales":"scale-x,scale-y",
        "values": waktu,
        "marker":{
          "size":3
        }
      },
      {
        "type":"line",
        "scales":"scale-x,scale-y-2",
        "values": akurasi,
        "marker":{
          "size":3
        }
      }
    ]
};

  zingchart.render({
  	id : 'grafikAkurasi',
  	data : configAkurasi,
  	height: '100%',
  	width: '100%'
  });


});
