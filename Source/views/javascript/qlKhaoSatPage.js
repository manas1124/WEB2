window.HSStaticMethods.autoInit(); // phải dùng câu lệnh này để dùng lại js component
function test() {
  console.log("test2");
}

async function getAllKhaoSat() {
  try {
    const response = await $.ajax({
      url: "./controller/KhaoSatController.php",
      type: "POST",
      data: { func: "getAllKhaoSat", data:  JSON.stringify({ ks_id: 1 } )},
      dataType: "json",
    });
    console.log("fect",response)
    return response;
  } catch (error) {
    console.log("loi fetchdata getAllKhaoSat 1")
    return null;
  }
}

async function getAllNhomKs() {
  try {
    const response = await $.ajax({
      url: "./controller/nhomKsController.php",
      type: "POST",
      data: { func: "getAllNhomKs"},
      dataType: "json",
    });
    return response;
  } catch (error) {
    console.log("loi fetchdata allnhomks ")
    return null;
  }
}
async function getKhaoSatById() {
  try {
    const response = await $.ajax({
      url: "./controller/KhaoSatController.php",
      type: "POST",
      data: JSON.stringify({ func: "getKhaoSatById", data: { ks_id: 1 } }),
    });
    return response; // Directly return the JSON response
  } catch (error) {
    console.log("loi fetchdata getKhaoSatById");
    return null;
  }
}

$(function () {

  $(".main-content").on("click",".action-item", function (e) {
      e.preventDefault();
      let action = $(this).data("act");
      console.log(action)
      // $(".main-content").load(`day la trang ${action}`)
  });


  (async () => {
    let ksList  = await getAllKhaoSat();
    // ksList = JSON.parse(ksList)
    if (ksList != null) {
      console.log(ksList)
      
      ksList.map((item) => {
        $("#ks-list").append(`
          <tr>
              <td>${item.ten_ks}</td>
              <td>${item.ngay_bat_dau}</td>
              <td>${item.ngay_ket_thuc}</td>
              <td class="text-center">
              ${
                item.su_dung == 1
                  ? '<span class="badge badge-soft badge-success ">Đang thực hiện</span>'
                  : '<span class="badge badge-soft badge-error ">Kết thúc</span>'
              }
              </td>
              <td>
                <button class="btn btn-circle btn-text btn-sm" aria-label="Action button"><span class="icon-[tabler--pencil] size-5"></span></button>
                <button class="btn btn-circle btn-text btn-sm" aria-label="Action button"><span class="icon-[tabler--trash] size-5"></span></button>
                <button class="btn btn-circle btn-text btn-sm" aria-label="Action button"><span class="icon-[tabler--dots-vertical] size-5"></span></button>
              </td>
          </tr>
  
        `);
      });
      
    }
    
    // let nhomKsList = await getAllNhomKs();
    // if (nhomKsList != null) {
    //   console.log(nhomKsList)
    //   nhomKsList.map( (nhom) =>{
    //     $("#select-nhom-ks").append(`
    //       <option value="aries"></option>
    //       `)
    //   } )
      
    // }


  })();
/*
  // xua li tao bai khao sat
  const survey = document.getElementById("survey-container");
  const btnAddSection = document.getElementById("btn-add-question");
  const submitSurveyButton = document.getElementById("btn-save-ks");

  btnAddSection.addEventListener("click", () => {
    const section = document.createElement("div");
    section.classList.add("mb-4","border","border-gray-300","p-8");
    section.classList.add("section");

    const sectionTitle = document.createElement("h3");
    sectionTitle.textContent = "Tên mục:"
    section.appendChild(sectionTitle);

    const sectionNameInput = document.createElement("input");
    sectionNameInput.placeholder = "Nhập tên mục";
    sectionNameInput.classList.add("input","mb-4");
    section.appendChild(sectionNameInput);

   
    // sectionNameInput.addEventListener("input", () => {
    //   sectionTitle.textContent =
    //     sectionNameInput.value || `Section ${survey.children.length + 1}`;
    // });

    const questionContainer = document.createElement("div");
    questionContainer.classList.add("question-container");
    section.appendChild(questionContainer);

    const btnAddQuestion = document.createElement("button");
    btnAddQuestion.textContent = "Thêm câu hỏi";
    btnAddQuestion.classList.add("btn","btn-primary","btn-sm");
    btnAddQuestion.addEventListener("click", () => {
      const question = document.createElement("div");
      question.classList.add("question-item","flex-row","flex","items-center","gap-4","mb-4");
      question.innerHTML = `
        <label class="label-text text-nowrap">Câu hỏi:</label>
        <input type="text" class="questionInput input w-s"/>
        <button class="deleteQuestion btn btn-square btn-outline btn-error">
          <span class="icon-[tabler--x]"></span>
        </button>
      `;
      questionContainer.appendChild(question);

      const deleteQuestionButton =
        question.querySelector(".deleteQuestion");
      deleteQuestionButton.addEventListener("click", () => {
        question.remove();
      });
    });
    section.appendChild(btnAddQuestion);

    const deleteSectionButton = document.createElement("button");
    deleteSectionButton.textContent = "Xóa mục";
    deleteSectionButton.classList.add("btn","btn-error","ml-[10px]","btn-sm");
    deleteSectionButton.addEventListener("click", () => {
      section.remove();
    });
    section.appendChild(deleteSectionButton);

    survey.appendChild(section);
  });

  submitSurveyButton.addEventListener("click", () => {
    const surveyData = [];
    const sections = survey.querySelectorAll(".section");

    sections.forEach((section, sectionIndex) => {
      const sectionName = section.querySelector("input").value;
      const questions = [];
      const questionElements = section.querySelectorAll(".question");

      questionElements.forEach((questionElement) => {
        const questionInput =
          questionElement.querySelector(".questionInput").value;
        questions.push(questionInput);
      });

      surveyData.push({
        sectionName: sectionName,
        questions: questions,
      });
    });

    console.log(JSON.stringify(surveyData, null, 2));
  });
  */
});

