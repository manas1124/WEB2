
var surveyId;

const doSurvey = (obj, surveyIdInput) => {
    surveyId = surveyIdInput;
    const act = $(obj).data("act");
    $.ajax({
        url: "/Source/handle/surveyHandler.php",
        type: "GET",
        data: {
            act: act,
            surveyId: surveyId,
        },
        dataType: "",
        success: function (data) {
            $("body").html(data);
            history.pushState({ surveyId: surveyId }, "Survey", "?act=" + act + "&surveyId=" + surveyId);
        },
        error: function (error) {
            console.error("Error loading survey:", error);
        }
    });
}
 
const sendSurvey = (obj) => {
    const act = $(obj).attr("name");
    const questions = $('tr > td[name^="txt-"]'); // Lấy tất cả các câu hỏi (có name bắt đầu bằng "txt-")
    // console.log(questions);
    const result = {};
    for (const question of questions) {
        const idQuestion = question.getAttribute("name").split("-")[1];
        const radio = $('input[name="radio-' + idQuestion + '"]:checked');
        const score = convertScore(radio.val());
        // console.log(question, idQuestion);
        // console.log(score);
        if (score == 0) {
            alert("Phải hoàn thành tất cả các câu hỏi trước khi gửi!");
            return;
        }
        result[idQuestion] = score;
        
    }
    
    // console.log(result);
    $.ajax({
        url: "/Source/handle/surveyHandler.php",
        type: "POST",
        data: {
            act: act,
            data: JSON.stringify(result),
            surveyId: surveyId,
            username: 'vana'
        },
        dataType: "json",
        success: function (data) {
            alert(data.message);            
            // history.pushState({}, "page", "?act=survey&surveyId=" + surveyId);
            
        },
        error: function (error) {
            console.error("Error loading survey:", error);
        }
    });
}

function convertScore(value) {
    switch (value) {
        case "rkhl":
            return 1;
        case "khl":
            return 2;
        case "bt":
            return 3;
        case "hl":
            return 4;
        case "hl":
            return 5;
        default:
            return 0;
    }
}