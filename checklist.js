
		    var month = new Array();
		    month[0] = "January";
		    month[1] = "February";
		    month[2] = "March";
		    month[3] = "April";
		    month[4] = "May";
		    month[5] = "June";
		    month[6] = "July";
		    month[7] = "August";
		    month[8] = "September";
		    month[9] = "October";
		    month[10] = "November";
		    month[11] = "December";
		    var weekday = new Array(7);
		    weekday[0] = "Sunday";
		    weekday[1] = "Monday";
		    weekday[2] = "Tuesday";
		    weekday[3] = "Wednesday";
		    weekday[4] = "Thursday";
		    weekday[5] = "Friday";
		    weekday[6] = "Saturday";
		    var d = new Date();
		    var n = month[d.getMonth()];
		    var currenttime = d.getHours() + ":" + d.getMinutes() + ":" + d.getSeconds();
		    document.getElementById("title").innerHTML = n + " " + d.getDate() +  ", "+ d.getFullYear()  ;
		    function submit_on_check(namestate) {

		    	var state=namestate.split("_")[0];
		    	var name=namestate.substring(namestate.indexOf("_")+1,namestate.length)

		    	if (state=="in" || state=="out"){
			    	if (state=="in") {
			    		$('[name='+namestate+']').parent().next().html("<input type=checkbox class=checkthem name=out_"+name+" onclick=submit_on_check(this.name)> Out");
					}
					$.post("check_update.php", $('form#checklist').serialize(),function(response){
						 $('[name='+namestate+']').parent().html(response);
					});
		    	}
		    	else{//when state is mid
		    		namestate=namestate.split(" ").join("_");
		    		name=name.split(" ").join("_");
		    		//console.log('[name=in_'+name+']')
		    		$.post("check_update.php", $('form#checklist').serialize(),function(response){
						$('[name=in_'+name+']').parent().prev().html(response);
					});
					var selector="#"+namestate
					$(selector).prop('checked',false);
		    	}
		    }
		    $(document).ready(function(){
		    	console.log($("#commentsBlock").height());
		    	$("#commentsarea").rows=5;	

		    });
		   
		    
		    $(".namerow").hover(
				function () {
				    $(this).css("background","#34495E");
				    $(this).css("color","#FFF");
				},
				function () {
				    $(this).css("background","");
				    $(this).css("color","#000");
				}
			);
