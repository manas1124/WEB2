
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
        if (isNaN(score)) {
            alert("Phải hoàn thành tất cả các câu hỏi trước khi gửi!");
            return;
        }
        result[idQuestion] = score;
        
    }
    
    // console.log(result);
    let username = null;
    (async () => {
        const account = await getCurrentLoginAccount();
        if (account && account.sub !== null) {
            console.log(account);
            username = account.sub;
        } else {
            alert("Không thể lấy thông tin người làm khảo sát")
            return;
        }
    })();
    
    $.ajax({
        url: "/Source/handle/surveyHandler.php",
        type: "POST",
        data: {
            act: act,
            data: JSON.stringify(result),
            surveyId: surveyId,
            username: username
        },
        dataType: "json",
        success: function (response) {
            alert(response['message']); // Show the message from the server     
            // history.pushState({}, "page", "?act=survey&surveyId=" + surveyId);
            
        },
        error: function (error) {
            console.error("Error loading survey:", error);
        }
    });
}

function convertScore(value) {
    return Number(value);
}

async function getCurrentLoginAccount() {
    try {
      const response = await $.ajax({
        url: "./controller/AuthController.php",
        type: "POST",
        dataType: "json",
        data: { func: "getCurrentLoginUser" },
      });
      if (response.status == "error") {
        console.log(response.message);
        return null;
      }
      return response.userInfor;
    } catch (error) {
      console.error(error);
      return null;
    }
  }

  