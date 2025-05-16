async function getNhomKs() {
  try {
    const response = await $.ajax({
      url: "./controller/nhomKsController.php",
      type: "GET",
      data: { func: "getAllNhomKs" },
      dataType: "json",
    });
    console.log("fect", response);
    return response;
  } catch (error) {
    console.log(error);
    console.log("loi fetchdata getAllKhaoSat 1");
    return null;
  }
}
async function getAllNganh() {
  try {
    const response = await $.ajax({
      url: "./controller/nganhController.php",
      type: "GET",
      data: { func: "getAll" },
      dataType: "json",
    });
    if (response.error) {
      console.log("fect", response.error);
    }
    return response;
  } catch (error) {
    console.log(error);
    console.log("loi fetchdata getAllKhaoSat 1");
    return null;
  }
}
async function getAllChuKi() {
  try {
    const response = await $.ajax({
      url: "./controller/chuKiController.php",
      type: "GET",
      data: { func: "getAllChuKi" },
      dataType: "json",
    });
    if (response.error) {
      console.log("fect", response.error);
    }
    return response;
  } catch (error) {
    console.log(error);
    console.log("loi fetchdata getAllKhaoSat 1");
    return null;
  }
}
async function getAllTraLoi() {
  try {
    const response = await $.ajax({
      url: "./controller/loaiTraLoiController.php",
      type: "GET",
      data: { func: "getAllTraLoi" },
      dataType: "json",
    });
    if (response.error) {
      console.log("fect", response.error);
    }
    console.log("fect", response);
    return response;
  } catch (error) {
    console.log(error);
    console.log("loi fetchdata getAllKhaoSat 1");
    return null;
  }
}
async function createKhaoSat(formData) {
  try {
    const response = await $.ajax({
      url: "./controller/KhaoSatController.php",
      type: "POST",
      data: formData,
      contentType: false,
      processData: false,
      dataType: "json",
    });
    if (response.status === "error") {
      console.log(response);
      Swal.fire({
        title: "Thông báo",
        html: response.message,
        icon: "warning",
      });
      return response;
    }
    if (response.status == "success") {
      Swal.fire({
        title: "Thông báo",
        html: "Tạo khảo sát thành công!",
        icon: "success",
      });
      $("#khao-sat-page").trigger("click");
    }
    return response;
  } catch (error) {
    console.log("Lỗi khi tạo khảo sát:", error);
    return false;
  }
}

//return -1:not found || ctdt id
async function checkExistCtdt(nganh_id, chu_ki_id, is_ctdt_daura) {
  console.log("check exit input", nganh_id, chu_ki_id, is_ctdt_daura);
  try {
    const response = await $.ajax({
      url: "./controller/KhaoSatController.php",
      type: "POST",
      data: {
        func: "checkExistCtdt",
        data: JSON.stringify({
          nganh_id: nganh_id,
          chu_ki_id: chu_ki_id,
          is_ctdt_daura: is_ctdt_daura,
        }),
      },
    });
    return response; // return id cdtd tim duoc
  } catch (e) {
    console.log("loi fetchdata loi kiem tra ctdt", e);
    return -1;
  }
}
$(function () {
  window.HSStaticMethods.autoInit();

  $("#surveyContentFormat").on("click", function () {
    // Replace 'path/to/your/excel/file.xlsx' with the actual path to your Excel file
    const excelFilePath = "./assets/sample_questions.xlsx";

    // Create a temporary link element
    const link = document.createElement("a");
    link.href = excelFilePath;
    link.download = "example_survey_format.xlsx"; // Specify the downloaded filename

    $("#input-file-survery-content").removeAttr("disabled");
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link); // Clean up
  });
  (async () => {
    const searchNhomKsInput = document.getElementById("search-nhom-ks");
    const nhomKsList = await getNhomKs();
    const nganhList = await getAllNganh();
    const chuKiList = await getAllChuKi();
    const answerTypeList = await getAllTraLoi();

    if (nhomKsList != null) {
      nhomKsList.map((item) => {
        $("#list-nhomks-option").append(
          `<div class="nhomks-option p-2 hover:bg-gray-200 cursor-pointer" 
          data-value='${item.nks_id}'>${item.ten_nks}</div>
          `
        );
      });
    }
    if (nganhList != null) {
      nganhList.map((item) => {
        $("#select-nganh").append(
          `<option value='${item.nganh_id}'>${item.ten_nganh}</option>`
        );
      });
    }
    if (chuKiList != null) {
      chuKiList.map((item) => {
        $("#select-chu-ki").append(
          `<option value='${item.ck_id}'>${item.ten_ck}</option>`
        );
      });
    }
    if (answerTypeList != null) {
      answerTypeList.map((item) => {
        $("#select-loai-tra-loi").append(
          `<option value='${item.ltl_id}'>${item.thang_diem}</option>`
        );
      });
    }

    // xu ly select search nhom khao sat
    const selectNhomKsBox = document.getElementById("select-nhomks-box");
    const nhomKsDropdown = document.getElementById("nhomKsDropdown");
    const nhomKsInput = document.getElementById("nhomKsInput");
    const nhomOptions = document.querySelectorAll(".nhomks-option");
    const selectedNhomKs = document.getElementById("selected-option");
    selectedNhomKs.value = "-1"; // default value is not select -1

    selectNhomKsBox.addEventListener("click", () => {
      nhomKsDropdown.classList.toggle("hidden");
      nhomKsInput.value = ""; // Clear search input when nhomKsDropdown opens
      filterOptions("");
    });

    nhomOptions.forEach((option) => {
      option.addEventListener("click", () => {
        selectedNhomKs.textContent = option.textContent;
        selectedNhomKs.value = option.dataset.value;
        nhomKsDropdown.classList.toggle("hidden");
      });
    });

    nhomKsInput.addEventListener("input", (e) => {
      filterOptions(e.target.value);
    });

    function filterOptions(query) {
      nhomOptions.forEach((option) => {
        if (option.textContent.toLowerCase().includes(query.toLowerCase())) {
          option.style.display = "block";
        } else {
          option.style.display = "none";
        }
      });
    }

    // Close nhomKsDropdown when clicking outside
    document.addEventListener("click", (e) => {
      if (
        !selectNhomKsBox.contains(e.target) &&
        !nhomKsDropdown.contains(e.target)
      ) {
        nhomKsDropdown.classList.add("hidden");
      }
    });

    // xua li tao bai noi dung khao sat
    const surveyContainer = document.getElementById("survey-container");
    const btnAddSection = document.getElementById("btn-add-question");
    const submitSurveyButton = document.getElementById("btn-save-ks");
    // loadSurveyContent(mockSurveyContent, surveyContainer);

    btnAddSection.addEventListener("click", () => {
      surveyContainer.appendChild(createSection({}));
    });

    //xu ly submit
    submitSurveyButton.addEventListener("click", () => {
      const surveyContent = [];
      const sections = surveyContainer.querySelectorAll(
        "div.section:not(.sub-section-container > div.section)"
      );

      const tenKhaoSat = $("#ten-ks").val();
      const idNhomKs = selectedNhomKs.value;
      const dateStart = $("#begin").val();
      const dateEnd = $("#end").val();
      const start = new Date(dateStart);
      const end = new Date(dateEnd);
      const today = new Date();
      today.setHours(0, 0, 0, 0);
      const loaiTraLoi = $("#select-loai-tra-loi").val();
      const nganh = $("#select-nganh").val();
      const chuKi = $("#select-chu-ki").val();
      const loaiKs = $("#select-ks-type").val();
      const isSuDung = $("#select-su-dung").val();
      const fileInput = document.getElementById("input-file-survery-content");
      const file = fileInput.files[0];

      function parseSection(sectionEl) {
        const sectionName = sectionEl.querySelector("input").value;
        const questions = Array.from(
          sectionEl.querySelectorAll(".question-item .questionInput")
        ).map((input) => input.value);

        const subSections = Array.from(
          sectionEl.querySelectorAll(
            ":scope > .sub-section-container > .section"
          )
        ).map(parseSection);

        return {
          sectionName,
          questions,
          subSections,
        };
      }

      sections.forEach((section) => {
        surveyContent.push(parseSection(section));
      });
      // neu subsection khac rong thi khong luu question content trong thu muc cha
      surveyContent.forEach((section) => {
        if (section.subSections.length > 0) {
          section.questions = [];
        }
      });
      let isValideData = () => {
        let messages = [];

        if (tenKhaoSat == "") {
          messages.push("Vui lòng nhập tên bài khảo sát");
        }
        if (idNhomKs == "-1") {
          messages.push("Vui lòng chọn nhóm bài khảo sát");
        }
        if (dateStart == "") {
          messages.push("Vui lòng chọn ngày bắt đầu");
        }
        if (dateEnd == "") {
          messages.push("Vui lòng chọn ngày kết thúc");
        }
        if (loaiTraLoi == "-1") {
          messages.push("Vui lòng chọn loại trả lời");
        }
        if (nganh == "-1") {
          messages.push("Vui lòng chọn ngành");
        }
        if (chuKi == "-1") {
          messages.push("Vui lòng chọn chu kì");
        }
        if (start < today) {
          messages.push("Ngày bắt đầu không được ở quá khứ.");
        }
        if (start > end) {
          messages.push("Ngày bắt đầu phải nhỏ hơn hoặc bằng ngày kết thúc.");
        }

        if (messages.length > 0) {
          Swal.fire({
            title: "Thông báo",
            html: messages[0],
            icon: "warning",
          });
          return false;
        }

        return true;
      };

      if (isValideData()) {
        checkExistCtdt(nganh, chuKi, loaiKs).then((isExistCtdt) => {
          if (isExistCtdt == -1) {
            Swal.fire({
              title: "Thông báo",
              html: "Không có chương trình đào tạo thuộc ngành, chu kì này",
              icon: "warning",
            });
            return;
          }

          const formData = new FormData();
          formData.append("func", "createKhaoSat"); //ten ham dung
          formData.append("ten-ks", tenKhaoSat);
          formData.append("nhomks-id", idNhomKs);
          formData.append("date-start", dateStart);
          formData.append("date-end", dateEnd);
          formData.append("loai-tra-loi", loaiTraLoi);
          formData.append("su-dung", isSuDung);
          formData.append("ctdt-id", isExistCtdt);

          if (file) {
            formData.append("excelFile", file);
          } else {
            formData.append("content", surveyContent);
            formData.append("content", JSON.stringify(surveyContent));
          }
          console.log(surveyContent);
          createKhaoSat(formData);
        });
      }
    });
  })();
});
function createSection(sectionData = {}, isSubsection = false) {
  const section = document.createElement("div");
  section.classList.add("mb-4", "border", "border-gray-300", "p-4", "section");
  if (isSubsection) section.classList.add("ml-4");

  const sectionTitle = document.createElement("h3");
  sectionTitle.textContent = isSubsection ? "Tên mục con:" : "Tên mục:";
  section.appendChild(sectionTitle);

  const sectionNameInput = document.createElement("input");
  sectionNameInput.placeholder = "Nhập tên mục";
  sectionNameInput.classList.add("input", "mb-4");
  sectionNameInput.value = sectionData.ten_muc || "";
  section.appendChild(sectionNameInput);

  const questionContainer = document.createElement("div");
  questionContainer.classList.add("question-container");
  section.appendChild(questionContainer);

  const subSectionContainer = document.createElement("div");
  subSectionContainer.classList.add("sub-section-container");
  section.appendChild(subSectionContainer);

  const btnAddQuestion = document.createElement("button");
  btnAddQuestion.textContent = "Thêm câu hỏi";
  btnAddQuestion.classList.add("btn", "btn-primary", "btn-sm", "mr-2");
  btnAddQuestion.addEventListener("click", () => {
    createQuestion(questionContainer);
    // ẩn nút thêm mục con nếu có câu hỏi
    btnAddSubSection.style.display = "none";
  });
  section.appendChild(btnAddQuestion);

  const btnAddSubSection = document.createElement("button");
  btnAddSubSection.textContent = "Thêm mục con";
  btnAddSubSection.classList.add("btn", "btn-secondary", "btn-sm", "mr-2");
  btnAddSubSection.addEventListener("click", () => {
    const subSec = createSection({}, true);
    subSectionContainer.appendChild(subSec);
    // ẩn nút thêm mục con nếu có câu hỏi
    btnAddQuestion.style.display = "none";
  });
  if (isSubsection) {
    btnAddSubSection.style.display = "none"; // mục con không cho thêm mục con
  }
  section.appendChild(btnAddSubSection);

  const deleteSectionButton = document.createElement("button");
  deleteSectionButton.textContent = isSubsection ? "Xóa mục" : "Xóa mục cha";
  deleteSectionButton.classList.add("btn", "btn-error", "btn-sm");
  deleteSectionButton.addEventListener("click", () => {
    const parentSection = section.parentElement.closest(".section");
    section.remove();

    // Nếu là mục con và sau khi xóa không còn mục con nào nữa
    if (isSubsection && parentSection) {
      const remainingSub = parentSection.querySelectorAll(
        ":scope > .sub-section-container > .section"
      );
      if (remainingSub.length === 0) {
        const btnAddQuestion =
          parentSection.querySelector("button.btn-primary");
        if (btnAddQuestion) btnAddQuestion.style.display = "inline-block";
      }
    }
  });

  section.appendChild(deleteSectionButton);

  // Add existing questions if any
  if (sectionData.cau_hoi && sectionData.cau_hoi.length > 0) {
    sectionData.cau_hoi.forEach((questionData) => {
      createQuestion(questionContainer, questionData.noi_dung);
    });
    btnAddSubSection.style.display = "none"; // nếu có sẵn câu hỏi thì ẩn nút thêm mục con
  }

  return section;
}

function createQuestion(questionContainer, questionText = "") {
  const question = document.createElement("div");
  question.classList.add(
    "question-item",
    "flex-row",
    "flex",
    "items-center",
    "gap-4",
    "mb-4"
  );
  question.innerHTML = `
    <label class="label-text text-nowrap">Câu hỏi:</label>
    <input type="text" class="questionInput input w-s" value="${questionText}"/>
    <button class="deleteQuestion btn btn-square btn-outline btn-error">
      <span class="icon-[tabler--x]">X</span>
    </button>
  `;
  questionContainer.appendChild(question);

  const deleteQuestionButton = question.querySelector(".deleteQuestion");
  deleteQuestionButton.addEventListener("click", () => {
    question.remove();

    const section = questionContainer.closest(".section");
    const questionItems = section.querySelectorAll(".question-item");

    // Chỉ hiển thị lại nút nếu là mục CHA (không phải mục con)
    const isSubSection = section.classList.contains("ml-4");
    if (!isSubSection && questionItems.length === 0) {
      const buttons = section.querySelectorAll("button");
      buttons.forEach((btn) => {
        if (btn.textContent.trim() === "Thêm mục con") {
          btn.style.display = "inline-block";
        }
      });
    }
  });
}
