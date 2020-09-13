var maxWord = 1000;

$(document).ready(function () {
    $("#text").focus(function(){

        if($(this).val()===''){
            jQuery(this).val('');
        }
    });
    $("#text").on( 'keyup paste',function(){
        if(jQuery(this).val()==='')
            $("#words-count").html(0+" words");
        countMyWords();
    });
});

function countMyWords() {
    var wordsCount=0;
    var dataContent = $("#text").val();
    dataContent = $.trim(dataContent);
    dataContent = dataContent.replace(/\s+/g," ");dataContent = dataContent.replace(/\n /," ");
    if(dataContent!=="")
    {
        wordsCount= dataContent.split(' ').length;
    }
    $("#words-count").html(wordsCount +" words");
    return wordsCount;
}

function validateForm() {
    var words = countMyWords();
    return words <= maxWord;
}