//convert bytes into friendly format
	function bytesToSize(bytes) {
		var sizes = ['Bytes', 'KB', 'MB'];
		if (bytes == 0) return 'n/a';
		var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
		return (bytes / Math.pow(1024, i)).toFixed(1) + ' ' + sizes[i];
	};
// check for selected crop region
	function checkForm() 
	{
		var img = $('#image_file').val();	

		var status=true;  

		  if (img == ''  )
		{
			document.getElementById("error_img").innerHTML = "The Thumb image field is required"; 
			status=false; 
		}
		else {
	        document.getElementById('error_img').innerHTML = "";
	    }

	   if(img!="")
	    {
	        if (!parseInt($('#w').val()))
		    {
		        $('.error').html('Please select a crop region and then press Save').show();
		        return false;
		    }
	    }
	    return status;  
	};

// update info by cropping (onChange and onSelect events handler)
	function updateInfo(e) 
	{

		if(e.w)
		{
			$('.sucess').html('Image cropped').show();
			$('#error_img').hide();
			$('.error').hide();
		}
		else
		{ 
			$('.sucess').hide();
		}
		$('#x1').val(e.x);
		$('#y1').val(e.y);
		$('#x2').val(e.x2);
		$('#y2').val(e.y2);
		$('#w').val(e.w);
		$('#h').val(e.h);
	};
// clear info by cropping (onRelease event handler)
	function clearInfo() 
	{
		$('.info #w').val('');
		$('.info #h').val('');
	};
// Create variables (in this scope) to hold the Jcrop API and image size
	var jcrop_api, boundx, boundy;
	function fileSelectHandler() 
	{
		var add = $('#add').val();
		var oFile = $('#image_file')[0].files[0];
		$('.error').hide();
		$('.sucess').hide();
		// check for image type (jpg and png are allowed)
		var rFilter = /^(image\/jpeg|image\/png)$/i;
		if (! rFilter.test(oFile.type)) {
			$('.error').html('Please select a valid image file (jpg and png are allowed)').show();
			$('.step2').hide();
			return false;
		}
		// check for file size
		if (oFile.size > 1024 * 1024) {
			$('.error').html('You have selected too big file, please select a one smaller image file').show();
			$('.step2').hide();
			return;
		}
		   
		// preview element
		var oImage = document.getElementById('preview');
		var oImages = document.getElementById('previews');
		
		// prepare HTML5 FileReader
		var oReader = new FileReader();
		oReader.onload = function(e) {
		// e.target.result contains the DataURL which we can use as a source of the image
		oImage.src = e.target.result;
		oImage.onload = function () { // onload event handler
		// display step 2
			if (oImage.naturalWidth < 60 || oImage.naturalHeight < 20) {
		       $('.error').html('Please select image of dimension more than 360 * 200').show();
		       $('.step2').hide();
		       return;
		    }

		   var admin_url = $('#admin_url').val();
		   $("#loading").html('<img src='+admin_url+'>');
		   $('#loading').fadeIn("fast");
		   $("#loading").fadeOut(3500);

		//$('.hide').hide();
		$('.step2').fadeIn(500);
		// display some basic image info
		var sResultFileSize = bytesToSize(oFile.size);
		$('#filesize').val(sResultFileSize);
		$('#filetype').val(oFile.type);
		$('#filedim').val(oImage.naturalWidth + ' x ' + oImage.naturalHeight);
		// destroy Jcrop if it is existed
		if (typeof jcrop_api != 'undefined') {
			jcrop_api.destroy();
			jcrop_api = null;
			$('#preview').width(oImage.naturalWidth);
			$('#preview').height(oImage.naturalHeight);
		}
		setTimeout(function(){
		// initialize Jcrop
			$('#preview').Jcrop({
				minSize: [32, 32], // min crop size
				aspectRatio :95/53, // keep aspect ratio 1:1
				bgFade: true, // use fade effect
				bgOpacity: .3, // fade opacity
				boxWidth: 800,   //Maximum width you want for your bigger images
				boxHeight: 800,  //Maximum Height for your bigger images
				onChange: updateInfo,
				onSelect: updateInfo,
				onRelease: clearInfo
			}, function(){
			// use the Jcrop API to get the real image size
				var bounds = this.getBounds();
				boundx = bounds[0];
				boundy = bounds[1];
				// Store the Jcrop API in the jcrop_api variable
				jcrop_api = this;
			});
		},3000);
		};
		  
	     oImages.src = e.target.result;
	        oImages.onload = function () { // onload event handler

	            // display step 2
	            $('.step2').fadeIn(500);

	            // display some basic image info
	            var sResultFileSize = bytesToSize(oFile.size);
	            $('#filesize').val(sResultFileSize);
	            $('#filetype').val(oFile.type);
	            $('#filedim').val(oImages.naturalWidth + ' x ' + oImages.naturalHeight);
	            // Create variables (in this scope) to hold the Jcrop API and image size
	            var jcrop_api, boundx, boundy;
	            // destroy Jcrop if it is existed
	            if (typeof jcrop_api != 'undefined') 
	                jcrop_api.destroy();
	        };

		};
		// read selected file as DataURL
		oReader.readAsDataURL(oFile);
	}
