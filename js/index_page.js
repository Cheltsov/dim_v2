



$(document).ready(function() {
    $("#tabs_tables").tabs({
        active: 0,
        event: "click",
        //heightStyle: 'content',
    });
});

$(document).ready(function(){
    $.post("../controlers/control_main_page.php",
        {wanna_course : "1"},
        function(data){
            var obj = JSON.parse(data);
            for(i=0;i<obj.length-1;i++){
                //$(".courses").append("<tr><td>"+obj[i]['ccy']+"</td><td>"+parseFloat(obj[i]['buy']).toFixed(2)+"</td><td>"+parseFloat(obj[i]['sale']).toFixed(2)+"</td></tr>");
                $(".courses").append("<tr><td>"+obj[i]['ccy']+"</td><td>"+parseFloat(obj[i]['buy']).toFixed(2)+"</td><td>"+parseFloat(obj[i]['sale']).toFixed(2)+"</td></tr>");
            }
        }
    );
});



