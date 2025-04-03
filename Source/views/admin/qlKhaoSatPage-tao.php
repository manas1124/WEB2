<a href="" class="back-link btn btn-soft ">Quay lại</a>

<h3 class="modal-title">Tạo bài khảo sát</h3>

<div class="overflow-y-auto">
    <!-- thong tin chung -->
    <div class="flex flex-row">
        <div class="pt-0 mb-4">
            <div class="mb-4">
                <label class="label-text" for="fullName"> Tên bài khảo sát </label>
                <input type="text" placeholder="John Doe" class="input" id="fullName" />
            </div>
            <div class="max-w-sm">
                <label class="label-text"> Nhóm khảo sát </label>
                <select id="select-nhom-ks" data-select='{
                                    "placeholder": "Chọn nhóm ",
                                    "toggleTag": "<button type=\"button\" aria-expanded=\"false\"></button>",
                                    "toggleClasses": "advance-select-toggle select-disabled:pointer-events-none select-disabled:opacity-40",
                                    "hasSearch": true,
                                    "dropdownClasses": "advance-select-menu dropdown max-h-52 pt-0 overflow-y-auto",
                                    "optionClasses": "advance-select-option selected:select-active",
                                    "optionTemplate": "<div class=\"flex justify-between items-center w-full\"><span data-title></span><span class=\"icon-[tabler--check] shrink-0 size-4 text-primary hidden selected:block \"></span></div>",
                                    "extraMarkup": "<span class=\"icon-[tabler--caret-up-down] shrink-0 size-4 text-base-content absolute top-1/2 end-3 -translate-y-1/2 \"></span>"
                                    }' class="hidden">
                    <option value="">Lựa chọn</option>
                    <option value="aries">Aries</option>
                    <option value="taurus">Taurus</option>
                </select>
            </div>
            <div class="mb-0.5 flex gap-4 max-sm:flex-col">
                <div class="w-full">
                    <label class="label-text" for="begin"> Bắt đầu </label>
                    <input type="date" class="input" id="begin" />
                </div>
                <div class="w-full">
                    <label class="label-text" for="end"> Kết thúc</label>
                    <input type="date" class="input" id="end" />
                </div>
            </div>
        </div>
        <div class="modal-body pt-0 mb-4">
            <div class="w-96">
                <label class="label-text" for="select-answer-type">Loại câu trả lời </label>
                <select class="select" id="select-answer-type">
                    <option>The Godfather</option>
                </select>
            </div>
            <div class="w-96">
                <label class="label-text" for="select-nganh">Ngành </label>
                <select class="select" id="select-nganh">
                    <option>The Godfather</option>
                </select>
            </div>
            <div class="w-96">
                <label class="label-text" for="select-chu-ki">Chu kì</label>
                <select class="select" id="select-chu-ki">
                    <option>The Godfather</option>
                </select>
            </div>
        </div>
    </div>
    <!-- cau hoi -->
    <div class="modal-body pt-0 mb-4">
        <p class="mb-4">
            Nội dung khảo sát
        </p>
        <div id="survey-container"></div>
        <button id="btn-add-question" class="btn btn-primary mb-4">Tạo mục câu hỏi</button>

    </div>
    <div class="modal-footer border-t border-base-content/10">
        <button id="btn-save-ks" type="submit" class="btn btn-primary">Lưu</button>
    </div>
</div>
<script>
$(function() {

    window.HSStaticMethods.autoInit();
    // xua li tao bai khao sat
    const survey = document.getElementById("survey-container");
    const btnAddSection = document.getElementById("btn-add-question");
    const submitSurveyButton = document.getElementById("btn-save-ks");

    btnAddSection.addEventListener("click", () => {
        const section = document.createElement("div");
        section.classList.add("mb-4", "border", "border-gray-300", "p-8");
        section.classList.add("section");

        const sectionTitle = document.createElement("h3");
        sectionTitle.textContent = "Tên mục:"
        section.appendChild(sectionTitle);

        const sectionNameInput = document.createElement("input");
        sectionNameInput.placeholder = "Nhập tên mục";
        sectionNameInput.classList.add("input", "mb-4");
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
        btnAddQuestion.classList.add("btn", "btn-primary", "btn-sm");
        btnAddQuestion.addEventListener("click", () => {
            const question = document.createElement("div");
            question.classList.add("question-item", "flex-row", "flex", "items-center", "gap-4",
                "mb-4");
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
        deleteSectionButton.classList.add("btn", "btn-error", "ml-[10px]", "btn-sm");
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
})
</script>