
var flag=0;
var vtotalQuestion=0;
var answer=[];


function showHola(){

    getQuestions();
    
}

function getQuestions(){

    $.ajax({
        type: "GET",
        async: true,
        url: "./php/get_ajax_questions.php",
        success:function(vresponse){
            vtotalQuestion=vresponse.length;
            var vhtml="";
            if(vtotalQuestion >0){
                for(i=0;i<vtotalQuestion;i++){
                  vhtml+='<dt>'+vresponse[i].test+' ';
                  vhtml+='&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp <IMG id="answer_y_'+(vresponse[i].indice-1)+'" class="imagen" onclick="getData(1,'+(vresponse[i].indice-1)+')" SRC="si.jpg"> &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp<IMG id="answer_n_'+(vresponse[i].indice-1)+'" class="imagen" onclick="getData(2,'+(vresponse[i].indice-1)+')" SRC="no.jpg"></dt>';
                  
                }
                $("#encuesta").html(vhtml);
            }
        },
        error:function(){
            alert("No se pudo acceder a los datos");
        }
    });
}


function getData(option,index){
    answer[index]=option;

    if(option==1){
        $("#answer_y_"+index).addClass("imagen-active");
        if($("#answer_n_"+index).hasClass("imagen-active")){
            $("#answer_n_"+index).removeClass("imagen-active")
        }
        else{
            checkAnswerAsk();
        }
    }
    else{
        $("#answer_n_"+index).addClass("imagen-active");

        if($("#answer_y_"+index).hasClass("imagen-active")){
            $("#answer_y_"+index).removeClass("imagen-active")
        }
        else{
          checkAnswerAsk();
        }
    }
    //parent.jQuery.fancybox.close();
}


function checkAnswerAsk(){
    flag++;
    //$("#answerUser").serialize();
    if(flag==vtotalQuestion){

        saveAnswer();
        alert("Gracias por realizar la encuesta!!!");

        //parent.jQuery.fancybox.close();
    }
}



function setInput(){

    total=answer.length;
    vhtml=""
    
    for(j=0;j<total;j++){
        vhtml+="<input name='answer_"+j+"' id='answer_"+j+"' value='"+answer[j]+"'>";
    }
    alert(vhtml);
    $("#answerUser").html(vhtml);
}

function saveAnswer(){
    setInput();

    $.ajax({
        type: "POST",
        async: true,
        data: $("#answerUser").serialize(),
        url: "./php/post_ajax_save_answer.php",
        success:function(vresponse){
            
        },
        error:function(){
            alert("No se pudo acceder a los datos");
        }
    });
}
