$(function(){
    var answerButtons = $(".answer");
    answerButtons.on("click",function(event){
        console.log("dziala");
    });
    
    var showAnswerButton = $(".showAnswer");
    showAnswerButton.on("click", function(event){
        var answer = $("#answer");
        var answerButtons = $(".answer");
        answerButtons.each(function(index,element){
            $(this).toggleClass('hidden');
        }),
        answer.toggleClass('hidden');
        // this.toggleClass('hidden');
    });
});