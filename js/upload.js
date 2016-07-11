
var abc = 0; //Declaring and defining global increement variable
var countCouv= 0,countSpon= 0,countAutr= 0,countOrg= 0;

$(document).ready(function() {

//To add new input file field dynamically, on click of "Add More Files" button below function will be executed

    $('#add_more_couv').click(function() {
        if(countCouv <=4){
            $(this).before($("<div/>", {id: 'filediv_couv'}).fadeIn('slow').append(
                $("<input/>", {accept: 'image/*', name: 'file_couv[]', type: 'file', id: 'file_couv' }),
                $("<br/><br/>")
            ));
            countCouv++;
        }else{
            $('#add_more_couv').hide();
        }
    });

    $('#add_more_spon').click(function() {
        if(countSpon <=4){
            $(this).before($("<div/>", {id: 'filediv_spon'}).fadeIn('slow').append(
                $("<input/>", {accept: 'image/*',name: 'file_spon[]', type: 'file', id: 'file_spon'}),
                $("<br/><br/>")
            ));
            countSpon++;
        }else{
            $('#add_more_spon').hide();
        }
    });

    $('#add_more_autr').click(function() {
        if(countAutr <=4){
            $(this).before($("<div/>", {id: 'filediv_autr'}).fadeIn('slow').append(
                $("<input/>", {accept: 'image/*',name: 'file_autr[]', type: 'file', id: 'file_autr'}),
                $("<br/><br/>")
            ));
            countAutr++;
        }else{
            $('#add_more_autr').hide();
        }
    });

    $('#add_more_org').click(function() {
        if(countOrg <=4){
            $(this).before($("<div/>", {id: 'filediv_org'}).fadeIn('slow').append(
                $("<input/>", {accept: 'image/*',name: 'file_org[]', type: 'file', id: 'file_org'}),
                $("<br/><br/>")
            ));
            countOrg++;
        }else{
            $('#add_more_org').hide();
        }
    });

//following function will executes on change event of file input to select different file	
$('body').on('change', '#file_couv', function(){
            if (this.files && this.files[0]) {
                 abc += 1; //increementing global variable by 1
				
				var z = abc - 1;
                var x = $(this).parent().find('#previewimg' + z).remove();
                $(this).before("<div id='abcd"+ abc +"' class='abcd'><img id='previewimg" + abc + "' src=''/></div>");
               
			    var reader = new FileReader();
                reader.onload = imageIsLoaded;
                reader.readAsDataURL(this.files[0]);
               
			    $(this).hide();
                $("#abcd"+ abc).append($("<img/>", {id: 'img', src: 'images/res/x.png', alt: 'delete'}).click(function() {
                $(this).parent().parent().remove();
                    countCouv--;
                    $('#add_more_couv').show();
                }));
            }
        });


    $('body').on('change', '#file_spon', function(){
        if (this.files && this.files[0]) {
            abc += 1;

            var z = abc - 1;
            var x = $(this).parent().find('#previewimg' + z).remove();
            $(this).before("<div id='abcd"+ abc +"' class='abcd'><img id='previewimg" + abc + "' src=''/></div>");

            var reader = new FileReader();
            reader.onload = imageIsLoaded;
            reader.readAsDataURL(this.files[0]);

            $(this).hide();
            $("#abcd"+ abc).append($("<img/>", {id: 'img', src: 'images/res/x.png', alt: 'delete'}).click(function() {
                $(this).parent().parent().remove();
                countSpon--;
                $('#add_more_spon').show();
            }));
        }
    });


    $('body').on('change', '#file_autr', function(){
        if (this.files && this.files[0]) {
            abc += 1;

            var z = abc - 1;
            var x = $(this).parent().find('#previewimg' + z).remove();
            $(this).before("<div id='abcd"+ abc +"' class='abcd'><img id='previewimg" + abc + "' src=''/></div>");

            var reader = new FileReader();
            reader.onload = imageIsLoaded;
            reader.readAsDataURL(this.files[0]);

            $(this).hide();
            $("#abcd"+ abc).append($("<img/>", {id: 'img', src: 'images/res/x.png', alt: 'delete'}).click(function() {
                $(this).parent().parent().remove();
                countAutr--;
                $('#add_more_autr').show();
            }));
        }
    });

    $('body').on('change', '#file_org', function(){
        if (this.files && this.files[0]) {
            abc += 1;

            var z = abc - 1;
            var x = $(this).parent().find('#previewimg' + z).remove();
            $(this).before("<div id='abcd"+ abc +"' class='abcd'><img id='previewimg" + abc + "' src=''/></div>");

            var reader = new FileReader();
            reader.onload = imageIsLoaded;
            reader.readAsDataURL(this.files[0]);

            $(this).hide();
            $("#abcd"+ abc).append($("<img/>", {id: 'img', src: 'images/res/x.png', alt: 'delete'}).click(function() {
                $(this).parent().parent().remove();
                countOrg--;
                $('#add_more_org').show();
            }));
        }
    });

    $('body').on('change', '#file_rep', function(){
        if (this.files && this.files[0]) {
            abc += 1; //increementing global variable by 1

            var z = abc - 1;
            var x = $(this).parent().find('#previewimg' + z).remove();
            $(this).before("<div id='abcd"+ abc +"' class='abcd'><img id='previewimg" + abc + "' src=''/></div>");

            var reader = new FileReader();
            reader.onload = imageIsLoaded;
            reader.readAsDataURL(this.files[0]);

            $(this).hide();
            $("#abcd"+ abc).append($("<img/>", {id: 'img', src: 'images/res/x.png', alt: 'delete'}).click(function() {
                $(this).parent().parent().remove();
                $(this).before($("<div/>", {id: 'filediv_rep'}).fadeIn('slow').append(
                    $("<input/>", {accept: 'image/*',name: 'file_rep[]', type: 'file', id: 'file_rep'}),
                    $("<br/><br/>")
                ));
                $("#file_rep").show();
            }));
        }
    });

//To preview image     
    function imageIsLoaded(e) {
        $('#previewimg' + abc).attr('src', e.target.result);
    };

    $('#valider').click(function(e) {
        var nameCouv = $("file_couv").val();
        console.log("resultat "+nameCouv);
        if (!nameCouv){
            alert("Sélectionner au moins une photo de couverture");
            e.preventDefault();
        }
    });
});