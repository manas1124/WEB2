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
async function updateKhaoSat(data) {
  try {
    const response = await $.ajax({
      url: "./controller/KhaoSatController.php",
      type: "POST",
      data: { func: "updateKhaoSat", data: JSON.stringify(data) },
      dataType: "json",
    });
    if (response.error) {
      console.log("fect", response.error);
    }
    console.log("update", response);
    return response;
  } catch (error) {
    console.log(error);
    console.log("loi  tao khao sat");
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
async function getChiTietKsById(id) {
  try {
    const response = await $.ajax({
      url: "./controller/KhaoSatController.php",
      type: "POST",
      data: { func: "getChiTietKsById", id: id },
      dataType: "json",
    });
    console.log("fect", response);
    return response;
  } catch (e) {
    console.log(e);
    console.log("loi fetchdata getAllKhaoSat");
    return null;
  }
}
async function getSurveryContentQuestion(id) {
  try {
    const response = await $.ajax({
      url: "./controller/KhaoSatController.php",
      type: "POST",
      data: { func: "getSurveyFieldAndQuestion", id: id },
      dataType: "json",
    });
    console.log("fect", response);
    return response;
  } catch (e) {
    console.log(e);
    console.log("loi fetchdata noi dung ks ");
    return null;
  }
}
$(function () {
  window.HSStaticMethods.autoInit();
  (async () => {
    const urlParams = new URLSearchParams(window.location.search);

    const currentKsId = urlParams.get("id");
    const defaultData = await getChiTietKsById(currentKsId);

    if (defaultData.su_dung == 1) {
      Swal.fire({
        title: "Thông báo",
        html: "Bài khảo sát đã bị đã đang được thực hiện, không được chỉnh sửa !",
        icon: "warning",
      });
      window.location.href = "./admin.php?page=qlKhaoSatPage";
      return;
    }
    const nhomKsList = await getNhomKs();
    const nganhList = await getAllNganh();
    const chuKiList = await getAllChuKi();
    const answerTypeList = await getAllTraLoi();
    const surveyContent = await getSurveryContentQuestion(currentKsId);

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
        if (item.nganh_id == defaultData.nganh_id) {
          $("#select-nganh").append(
            `<option value='${item.nganh_id}' selected="selected">${item.ten_nganh}</option>`
          );
        }
        $("#select-nganh").append(
          `<option value='${item.nganh_id}'>${item.ten_nganh}</option>`
        );
      });
    }
    if (chuKiList != null) {
      chuKiList.map((item) => {
        if (item.ck_id == defaultData.ck_id) {
          $("#select-chu-ki").append(
            `<option selected="selected" value='${item.ck_id}'>${item.ten_ck}</option>`
          );
        }
        $("#select-chu-ki").append(
          `<option value='${item.ck_id}'>${item.ten_ck}</option>`
        );
      });
    }
    if (answerTypeList != null) {
      answerTypeList.map((item) => {
        $("#select-loai-tra-loi").append(
          `<option ${
            defaultData.ltl_id == item.ltl_id ? 'selected="selected" ' : ""
          }  
              value='${item.ltl_id}'>${item.thang_diem}</option>`
        );
      });
    }
    //xu li gia tri mac dinh
    $("#select-su-dung").val(defaultData.su_dung);
    $("#select-ks-type").val(defaultData.la_ctdt);
    $("#ten-ks").val(defaultData.ten_ks);
    $("#begin").val(defaultData.ngay_bat_dau);
    $("#end").val(defaultData.ngay_ket_thuc);
    $("#selected-nhom-ks").val(defaultData.nks_id);
    const defaultNhomKsValue = defaultData.nks_id;
    // xu ly select search nhom khao sat
    const selectNhomKsBox = document.getElementById("select-nhomks-box");
    const nhomKsDropdown = document.getElementById("nhomKsDropdown");
    const nhomKsInput = document.getElementById("nhomKsInput");
    const selectedNhomKs = document.getElementById("selected-nhom-ks");

    const existingDefaultOption = document.querySelector(
      `#list-nhomks-option .nhomks-option[data-value="${defaultNhomKsValue}"]`
    );

    if (existingDefaultOption) {
      selectedNhomKs.textContent = existingDefaultOption.textContent;
      selectedNhomKs.value = existingDefaultOption.dataset.value;
    }

    const nhomOptions = document.querySelectorAll(".nhomks-option");

    selectNhomKsBox.addEventListener("click", () => {
      nhomKsDropdown.classList.toggle("hidden");
      nhomKsInput.value = "";
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
    //xu lý thêm nội dung
    const survey = document.getElementById("survey-container");
    const btnAddSection = document.getElementById("btn-add-question");
    const submitSurveyButton = document.getElementById("btn-save-ks");

    function createSection(sectionData) {
      const section = document.createElement("div");
      section.classList.add(
        "mb-4",
        "border",
        "border-gray-300",
        "p-8",
        "section"
      );

      const sectionTitle = document.createElement("h3");
      sectionTitle.textContent = "Tên mục:";
      section.appendChild(sectionTitle);

      const sectionNameInput = document.createElement("input");
      sectionNameInput.placeholder = "Nhập tên mục";
      sectionNameInput.classList.add("input", "mb-4");
      sectionNameInput.value = sectionData.ten_muc || "";
      section.appendChild(sectionNameInput);

      const questionContainer = document.createElement("div");
      questionContainer.classList.add("question-container");
      section.appendChild(questionContainer);

      const btnAddQuestion = document.createElement("button");
      btnAddQuestion.textContent = "Thêm câu hỏi";
      btnAddQuestion.classList.add("btn", "btn-primary", "btn-sm");
      btnAddQuestion.addEventListener("click", () => {
        createQuestion(questionContainer);
      });
      section.appendChild(btnAddQuestion);

      const deleteSectionButton = document.createElement("button");
      deleteSectionButton.textContent = "Xóa mục";
      deleteSectionButton.classList.add(
        "btn",
        "btn-error",
        "ml-[10px]",
        "btn-sm"
      );
      deleteSectionButton.addEventListener("click", () => {
        section.remove();
      });
      section.appendChild(deleteSectionButton);

      // Add existing questions if any
      if (sectionData.cau_hoi && sectionData.cau_hoi.length > 0) {
        sectionData.cau_hoi.forEach((questionData) => {
          createQuestion(questionContainer, questionData.noi_dung);
        });
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
          <span class="icon-[tabler--x]"></span>
        </button>
      `;
      questionContainer.appendChild(question);

      const deleteQuestionButton = question.querySelector(".deleteQuestion");
      deleteQuestionButton.addEventListener("click", () => {
        question.remove();
      });
    }

    btnAddSection.addEventListener("click", () => {
      survey.appendChild(createSection({}));
    });

    // Create sections and questions based on the sample data
    if (surveyContent) {
      Object.values(surveyContent).forEach((sectionData) => {
        survey.appendChild(createSection(sectionData));
      });
    }
    //xu ly submit
    submitSurveyButton.addEventListener("click", () => {
      const surveyContent = [];
      const sections = survey.querySelectorAll(".section");

      const tenKhaoSat = $("#ten-ks").val();
      const idNhomKs = selectedNhomKs.value;
      const dateStart = $("#begin").val();
      const dateEnd = $("#end").val();
      const loaiTraLoi = $("#select-loai-tra-loi").val();
      const nganh = $("#select-nganh").val();
      const chuKi = $("#select-chu-ki").val();
      const loaiKs = $("#select-ks-type").val();
      const isSuDung = $("#select-su-dung").val();
      const start = new Date(dateStart);
      const end = new Date(dateEnd);
      const today = new Date();
      today.setHours(0, 0, 0, 0);

      sections.forEach((section) => {
        const sectionName = section.querySelector("input").value;
        const questions = [];
        const questionElements = section.querySelectorAll(".question-item");

        questionElements.forEach((questionElement) => {
          const questionInput =
            questionElement.querySelector(".questionInput").value;
          questions.push(questionInput);
        });

        surveyContent.push({
          sectionName: sectionName,
          questions: questions,
        });
      });

      const editSurveyData = {
        "ks-id": currentKsId,
        "ten-ks": tenKhaoSat,
        "nhomks-id": idNhomKs,
        "date-start": dateStart,
        "date-end": dateEnd,
        "loai-tra-loi": loaiTraLoi,
        content: surveyContent,
        "su-dung": isSuDung,
      };

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
      console.log(editSurveyData);

      if (isValideData()) {
        checkExistCtdt(nganh, chuKi, loaiKs).then((isExistCtdt) => {
          if (isExistCtdt == -1) {
            Swal.fire({
              title: "Thông báo",
              html: "không có chương trình đào đạo thuộc ngành, chu kì này",
              icon: "warning",
            });
            return;
          }
          editSurveyData["ctdt-id"] = isExistCtdt;
          if (
            confirm(
              "Nếu cập nhật sẽ mất kết quả của bài khảo sát cũ (nếu có) ??"
            )
          ) {
            updateKhaoSat(editSurveyData).then((response) => {
              if (response) {
                $("#khao-sat-page").trigger("click");
                Swal.fire({
                  title: "Thông báo",
                  html: "Cập nhật thành công",
                  icon: "success",
                });
              } else {
                Swal.fire({
                  title: "Thông báo",
                  html: "Cập nhật thất bại",
                  icon: "warning",
                });
                alert("");
              }
            });
          }
        });
      }
    });
  })();
});
