var abc = 0; //Declaring and defining global increement variable

$(document).ready(function() {
        //To add new input file field dynamically, on click of "Add More Files" button below function will be executed
    $('#add_more').click(function() 
    {
        $(this).before($("<div/>", {id: 'filediv'}).fadeIn('slow').append(
                $("<input/>", {name: 'file[]', type: 'file', id: 'file'}),
                $("<input/>", {name: 'title[]', type: 'text', id: 'title',placeholder: 'Please enter Title here'}),        
                $("<br/><br/>")
                ));
    });

    //following function will executes on change event of file input to select different file	
    $('body').on('change', '#file', function(){
        if (this.files && this.files[0]) {
             abc += 1; //increementing global variable by 1
			var z = abc - 1;
            var x = $(this).parent().find('#previewimg' + z).remove();
            $(this).before("<div id='abcd"+ abc +"' class='abcd'><img id='previewimg" + abc + "' src=''/></div>");
		    var reader = new FileReader();
            reader.onload = imageIsLoaded;
            reader.readAsDataURL(this.files[0]);
            var png = $('#png').val(); 
		    $(this).hide();
            $("#abcd"+ abc).append($("<img/>", {id: 'img', src: png, alt: 'delete'}).click(function() {
            $(this).parent().parent().remove();

            }));
        }
    });

    //To preview image     
    function imageIsLoaded(e) 
    {
        $('#previewimg' + abc).attr('src', e.target.result);
    };

    $('#upload').click(function(e) {
       // $('#filediv').load(document.URL +  ' #filediv');
        var name = $("#file").val();
        var title = $("#title").val();
        if (!name)
        {
            alert("First Image Must Be Selected");
            return false;
            e.preventDefault();
        }
        if (!title)
        {
            alert("First Image Title Must Be Selected");
             return false;
            e.preventDefault();
        }
    });

});


