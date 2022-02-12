
require.config({
    baseUrl: UIFORM_SRC,
    paths: {
       
        script1: 'assets/frontend/js/iframe/iframeResizer.min'
    },
   waitSeconds: 0
});

require(['script1'], 
function(iFrameResize) {
iFrameResize({
				log                     : false,
                                autoResize: false,
                                sizeWidth: true,
                                scrollCallback: function (coords) {
                                    /*console.log("[OVERRIDE] overrode scrollCallback x: " + coords.x + " y: " + coords.y);*/
                                }
			});
});
