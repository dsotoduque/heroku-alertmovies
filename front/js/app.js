
$( document ).ready(function() {
    console.log( "ready!" );
    
    $("#srch_btn").click(function(){
        $('.classing').empty();
    	var name  = $("#nameAct").val();
    	var json;
    	var url = "http://localhost/TestTMDBAlert/RestProof/public/find/"+name;
    	console.log(url);
    	 $.ajax({ url: url,
    	 		  type:'GET',
    	 		  dataType: 'json', 
    	 }).done(function(data){
            console.log(data.value[0]);
            var length = data.value.length;
            console.log(length);
            var html = "";
            for (var i = 0; i<length; i++){
                //var strReplace = data.value[i].replace(" ","-");
             html += '<li style=" padding-left: 3px; list-style: none; font-family: Helvetica; "><a class="description" style=" font-size: 14px; color: rgb(50, 50, 50);text-decoration: none; " href="javascript:;">'+data.value[i]+'</a></li>';
            }
            $('.classing').append(html);
            $('.description').click(function(){
                $('#description').empty();
                var nameMovie = $(this).text();
                var url = "http://localhost/TestTMDBAlert/RestProof/public/description/"+nameMovie;
                $.ajax({
                    url: url,
                    type:'GET',
                    dataTpe:'json'
                }).done(function(json){
                    console.log(json);
                    $('#description').append('<p style="font-size: 14px; font-weight: bold;">Description</p><p>'+json.overview+'</p>');
                    var cast= '<p>Cast</p>';
                    var content= json.cast.length;
                    for (var i =0; i < content; i++) {
                        cast += '<li style="list-style: none;"><a style="color: rgb(70,70,70); text-decoration: none;" class="biography" href="javascript:;">'+json.cast[i]+'</a></li>'
                    }
                    $('#description').append(cast);

                    $('.biography').click(function () {
                        var nameOfActor= $(this).text();
                        var urlBio = "http://localhost/TestTMDBAlert/RestProof/public/biography/"+nameOfActor;
                        $.ajax({
                            url:urlBio,
                            type:'GET',
                            dataType:'json'
                        }).done(function(transfer){
                            $('#description').empty();
                            $('#description').append("<p><h3>Information</h3></p>");
                            $('#description').append("<p> Biography: "+transfer.biography+"</p>");
                            $('#description').append("<p>Birthday: "+transfer.birthday+"</p>");
                            $('#description').append("<p>Popularity:"+transfer.popularity+"</p>");
                        });
                    })
                });
            });
         });
    });
});
