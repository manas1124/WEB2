
const doSurvey = (obj, surveyId) => {
    const act = $(obj).data("act");
    $.ajax({
        url: "/Source/handle/surveyHandler.php",
        type: "GET",
        data: { surveyId: surveyId },
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