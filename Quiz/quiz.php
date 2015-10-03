<?php
	echo $streamline->quiz_xml;
?>

<!-- Quiz -->

<!-- Modal -->
<div class="modal fade" id="quizModal" role="dialog">
	<div class="modal-dialog">
		<div class="modal-header header-shadow">
			<button type="button" id="modal_close" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">Quiz</h4>
		</div>
		<div class="modal-body">
		
			<form id="quizForm">
			</form>
			
		</div>
		<div class="modal-footer">
		  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		</div>
	  
	</div>
</div>

<script>

	function loadXMLDoc(filename)
	{
		if (window.XMLHttpRequest)
		{
			xhttp=new XMLHttpRequest();
		}
		else // code for IE5 and IE6
		{
			xhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xhttp.open("GET",filename,false);
		xhttp.send();
		return xhttp.responseXML;
	}
	
	$(".quiz_button").hover(function() {
		$( ".quiz_button" ).toggleClass( "open" )
		if($("#dropdownMenu1").attr("aria-expanded") == true) {
			$("#dropdownMenu1").attr("aria-expanded", false)		
		} else {
			$("#dropdownMenu1").attr("aria-expanded", true)
		}
	}, function() {
		$( ".quiz_button" ).toggleClass( "open" )
		if($("#dropdownMenu1").attr("aria-expanded") == true) {
			$("#dropdownMenu1").attr("aria-expanded", false)		
		} else {
			$("#dropdownMenu1").attr("aria-expanded", true)
		}
	});

	// XML string to JSON    
	var x2js = new X2JS(); 
	var xml = loadXMLDoc('Quiz/quiz_example.xml');
	var xmlText = new XMLSerializer().serializeToString(xml);
	xmlText = <?=json_encode($streamline->quiz_xml)?>;
	console.log("QUIZ");
	console.log(xmlText);
	var quizJSON = x2js.xml_str2json( xmlText );

	var currentQuizId;
	
	if(quizJSON.quizzes.quiz instanceof Array) {
		for(i=0; i< quizJSON.quizzes.quiz.length; i++) {
			var quiz = "<li class='quizOption' data-toggle='modal' data-target='#quizModal' onclick='populateQuiz("+(i)+")'>Quiz "+(i+1)+"</li>";
			$("#quiz_menu").append(quiz);
		}		
	} else {
		console.log("Added drop down");
		i = 0;
		var quiz = "<li class='quizOption' data-toggle='modal' data-target='#quizModal' onclick='populateQuiz("+(i)+")'>Quiz "+(i+1)+"</li>";
		$("#quiz_menu").append(quiz);
	}
	
	var summaryData;
	
	function QuizSummary(id) {
	
		$('.modal-title').text("Quiz " + (id+1));
		$("#quizForm").empty();
		
		console.log("Obtaining Results");
		obtainSummaryData();
		
		sid = <?=json_encode($streamline->id)?>;
		cid = <?=json_encode($COURSE->id)?>
		
		data={ "qid" : id, "sid" : sid, "cid" : cid};
		console.log(data);
		
		function obtainSummaryData(){
            $.ajax({
                type: "POST",
                url: "Quiz/quiz_results.php",
                data: {data:id},
                success: function(data){
					console.log(data);
					summaryData = JSON.parse(data);
					displayQuizSummary(summaryData);
                }
            });
        }
		
	}
	
	function displayQuizSummary(data) {
		console.log("Loading Quiz Summary");
		$('.modal-title').text(summaryData.quiz);
			
		//Obtain number of quizzes
		if(quizJSON.quizzes.quiz instanceof Array) {
			quiz = quizJSON.quizzes.quiz[id];
		} else {
			quiz = quizJSON.quizzes.quiz;
		}
		
		var percentage;
		var number_of_questions = summaryData.data.length;
		for(i=0; i<number_of_questions; i++) {
				if(number_of_questions == 1) {
					console.log("Single Question");
					$("#quizForm").append("<b>Question " + (i+1) + "</b> : " + quiz.question._text + "<br>");
					question = quiz.question;
				} else {
					console.log("Multiple Questions");
					$("#quizForm").append("<b>Question " + (i+1) + "</b> : " + quiz.question[i]._text + "<br>");
					question = quiz.question[i];
				}
				right_percentage = summaryData.data[i][1]*100;
				wrong_percentage = 100-right_percentage;
				$("#quizForm").append('<div class="progress"><div class="progress-bar progress-bar-striped progress-bar-success active" style="width: '+right_percentage+'%">'+right_percentage+'%<span class="sr-only">'+right_percentage+'% Complete (success)</span></div><div class="progress-bar progress-bar-striped progress-bar-danger active" style="width: '+wrong_percentage+'%">'+wrong_percentage+'%<span class="sr-only">'+wrong_percentage+'% Complete (danger)</span></div></div>');
		}
		
		/*
		<div class="progress">
		  <div class="progress-bar progress-bar-success" style="width: 35%">
			<span class="sr-only">35% Complete (success)</span>
		  </div>
		  <div class="progress-bar progress-bar-warning progress-bar-striped" style="width: 20%">
			<span class="sr-only">20% Complete (warning)</span>
		  </div>
		  <div class="progress-bar progress-bar-danger" style="width: 10%">
			<span class="sr-only">10% Complete (danger)</span>
		  </div>
		</div>
		*/
	}
	
	
	function populateQuiz(id) {
	
		currentQuizId = id+1;
		
		$('.modal-title').text("Quiz " + (id+1));
		
		//Check if a quiz with the specified ID exists
		
		//Obtain number of quizzes
		if(quizJSON.quizzes.quiz instanceof Array) {
			number_of_quizzes = quizJSON.quizzes.quiz.length;
			quiz = quizJSON.quizzes.quiz[id];
		} else {
			number_of_quizzes = 1;
			quiz = quizJSON.quizzes.quiz;
		}
				
		if(id <= number_of_quizzes) {
			$("#quizForm").empty();
			
			//Obtain number of questions
			if(quiz.question instanceof Array) {
				number_of_questions = quiz.question.length;
			} else {
				number_of_questions = 1;
			}

			for(i=0; i<number_of_questions; i++) {
				if(number_of_questions == 1) {
					$("#quizForm").append("<b>Question " + (i+1) + "</b> : " + quiz.question._text + "<br>");
					question = quiz.question;
				} else {
					$("#quizForm").append("<b>Question " + (i+1) + "</b> : " + quiz.question[i]._text + "<br>");
					question = quiz.question[i];
				}
				
				//Obtain number of options
				if(question.option instanceof Array) {
					number_of_options = question.option.length;
				} else {
					number_of_options = 1;
				}
				
				for(j=0; j<number_of_options; j++) {
					if(number_of_options == 1) {
						var option = question.option._text;
					} else {
						var option = question.option[j]._text;
					}
					$("#quizForm").append("<input type='checkbox' id='"+(i+1)+"."+(j+1)+"' name='quiz"+(id+1)+" value='"+option+"'/>"+option+"<br>");
				}
				$("#quizForm").append("<br>");
			}
			
			$("#quizForm").append('<input type="hidden" name="action" value="quiz_submit" /><input type="submit" value="Submit" id="submit"name="submit">');

		}
	}
	
	var data;
	$('#quizForm').submit(function() {
	
		var answerArray = []
		
		var checkboxes = $('input:checkbox');
		
		for(i=0;i<checkboxes.length;i++) {
			if(checkboxes[i].checked) {
				answerArray.push(checkboxes[i].id);
			}
		}
	
		sid = <?=json_encode($cm->id)?>;
		stuid = <?=json_encode($USER->id)?>;
		cid = <?=json_encode($COURSE->id)?>;
		qid = currentQuizId;
		
		data={ "qid" : qid, "sid" : sid, "cid" : cid, "stuid" : stuid, "answers" : answerArray };
		
		console.log(data);
		
		$.post('Quiz/quiz_submit.php', data, function(data) {
		});
		
		QuizSummary(currentQuizId);
		
		//$('#quizModal').hide();
		//$('.modal-backdrop').hide();
		//$('body').removeClass( "modal-open" );

	  return false;
	});

</script>