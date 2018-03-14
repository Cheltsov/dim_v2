$(document).ready(function(){
    var d = new Date();
    var curr_date = d.getDate();
    if(curr_date<10) curr_date="0"+curr_date;
    var curr_month = d.getMonth() + 1;
    if(curr_month<10) curr_month="0"+curr_month;
    var curr_year = d.getFullYear();
    now = curr_year + "-" + curr_month + "-" + curr_date;
    GetAllTr(now);
});

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
                $(".courses").append("<tr><td>"+obj[i]['ccy']+"</td><td>"+obj[i]['buy']+"</td><td>"+obj[i]['sale']+"</td></tr>");
            }
        }
    );
});

function GetAllTr(tr_data){
    $("#minTable").empty();
    $("#plusTable").empty();
    $("#transTable").empty();
    $.post("../controlers/control_main_page.php",
        {getTrMinFromData : "1",data_tr : tr_data},
        function(data){
            $("#minTable").append("<tr><th>Имя</th><th>Кошелек</th><th>Сумма</th><th>Коммент</th><th>Пользователь</th><th>Дата</th></tr>");
            data = JSON.parse(data);
            for(i=1,j=2,a=3,b=4,c=5,d=6,il=0;i<data.length;i+=7,j+=7,a+=7,b+=7,c+=7,d+=7,il+=7){
                $("#minTable").append("<tr id='"+data[il]+"' class='col'>" +"<td id='name'>"+data[i]+"&nbsp</td>" + "<td id='cash'>"+data[j]+"</td>"+ "<td>"+data[a]+"</td>"+  "<td>"+data[b]+"</td>" + "<td>"+data[c]+"</td>" +  "<td>"+data[d]+"</td>"+ "</tr>");
            }
        }
    );
    $.post("../controlers/control_main_page.php",
        {getTrPlusFromData : "1",data_tr :tr_data},
        function(data){
            $("#plusTable").append("<tr><th>Имя</th><th>Кошелек</th><th>Сумма</th><th>Коммент</th><th>Пользователь</th><th>Дата</th></tr>");
            data = JSON.parse(data);
            for(i=1,j=2,a=3,b=4,c=5,d=6,il=0;i<data.length;i+=7,j+=7,a+=7,b+=7,c+=7,d+=7,il+=7){
                $("#plusTable").append("<tr id='"+data[il]+"' class='col'>" +"<td id='name'>"+data[i]+"&nbsp</td>" + "<td id='cash'>"+data[j]+"</td>"+ "<td>"+data[a]+"</td>"+  "<td>"+data[b]+"</td>" + "<td>"+data[c]+"</td>" +  "<td>"+data[d]+"</td>"+ "</tr>");
            }
        }
    );
    $.post("../controlers/control_main_page.php",
        {getTransFromData : "1", data_tr : tr_data},
        function(data){
            $("#transTable").append("<tr><th>Имя</th><th>Кошелек1</th><th>Снято</th><th>Кошелек2</th><th>Зачислено</th><th>Комментарий</th><th>Пользователь</th><th>Дата</th></tr>");
            data = JSON.parse(data);
            for(i=1,j=2,a=3,b=4,c=5,d=6,e=7,f=8,il=0;i<data.length;i+=9,j+=9,a+=9,b+=9,c+=9,d+=9,il+=9,e+=9,f+=9){
                $("#transTable").append("<tr id='ts"+data[il]+"' class='col'>" +"<td id='name'>"+data[i]+"&nbsp</td>" + "<td id='cash'>"+data[a]+"</td>"+ "<td>"+data[b]+"</td>"+  "<td>"+data[c]+"</td>" + "<td>"+data[d]+"</td>" +  "<td>"+data[e]+"</td>"+ "<td>"+data[f]+"</td>"+"<td>"+data[j]+"</td>"+"</tr>");
            }
        }
    );
}

