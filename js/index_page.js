$('.calender').pignoseCalendar({
    lang: 'en',
    date: moment(),
    week:1,
    theme: 'blue',
    format: 'YYYY-MM-DD',
    select: function(date, context) {
        alert(date[0]['_i']); // получить дату
    }
});

$(document).ready(function(){
    $.post("../controlers/control_main_page.php",
        {wanna_course : "1"},
        function(data){
            var obj = JSON.parse(data);
            for(i=0;i<obj.length-1;i++){
                $(".courses").append("<tr><td>"+obj[i]['ccy']+"</td><td>"+obj[i]['buy']+"</td><td>"+obj[i]['sale']+"</td></tr>");
            }
        }
    );
});

