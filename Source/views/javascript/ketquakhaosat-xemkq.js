async function getAllMucKhaoSat(ks_id) {
    try {
        const response = await $.ajax({
            url: "./controller/ketQuaKhaoSatController.php",
            type: "GET",
            dataType: "json",
            data: {
                func: "getMucKhaoSat",
                ks_id: ks_id
            },
        });
        return response;
    } catch (error) {
        console.error(error);
        return null;
    }
}
async function getAllCauHoi(mks_ids) {
    try {
        const response = await $.ajax({
            url: "./controller/ketQuaKhaoSatController.php",
            type: "GET",
            dataType: "json",
            data: {
                func: "getCauHoi",
                mks_ids: mks_ids
            },
        });
        return response;
    } catch (error) {
        console.error(error);
        return null;
    }
}
async function getAllKqks(ks_id) {
    try {
        const response = await $.ajax({
            url: "./controller/ketQuaKhaoSatController.php",
            type: "GET",
            dataType: "json",
            data: {
                func: "getAllByKsId",
                ks_id: ks_id
            },
        });
        return response;
    } catch (error) {
        console.error(error);
        return null;
    }
}
async function getAllDoiTuong(dt_ids) {
    try {
        const response = await $.ajax({
            url: "./controller/doiTuongController.php",
            type: "GET",
            dataType: "json",
            data: {
                func: "getByIds",
                dt_ids: dt_ids
            },
        });
        return response;
    } catch (error) {
        console.error(error);
        return null;
    }
}
async function getAllTraLoi(kqks_ids) {
    try {
        const response = await $.ajax({
            url: "./controller/ketQuaKhaoSatController.php",
            type: "GET",
            dataType: "json",
            data: {
                func: "getTraLoi",
                kqks_ids: kqks_ids
            },
        });
        return response;
    } catch (error) {
        console.error(error);
        return null;
    }
}

async function loadDuLieu(ks_id) {
    const mucKhaoSat = await getAllMucKhaoSat(ks_id);
    const mks_ids = mucKhaoSat.map(item => item.mks_id);

    // 2. Lấy danh sách câu hỏi theo mks_ids
    const cauHoi = await getAllCauHoi(mks_ids);

    // 3. Lấy kết quả khảo sát
    const kqks = await getAllKqks(ks_id);
    const kqks_ids = kqks.data.map(item => item.kqks_id);
    const doiTuong_ids = kqks.data.map(item => item.nguoi_lamks_id);

    // 4. Lấy thông tin đối tượng
    const doiTuong = await getAllDoiTuong(doiTuong_ids);

    // 5. Lấy danh sách trả lời
    const traLoi = await getAllTraLoi(kqks_ids);

    console.log(mucKhaoSat);
    console.log(cauHoi);
    console.log(kqks);
    console.log(doiTuong);
    console.log(traLoi);


    // 6. Tạo tiêu đề bảng
    const cauhoiList = document.getElementById('cauhoi-list');
    cauhoiList.innerHTML = ''; // Xóa nội dung cũ

    const headerRow = document.createElement('tr');
    const emailTh = document.createElement('th');
    emailTh.textContent = 'Email';
    headerRow.appendChild(emailTh);

    // Tạo tiêu đề cho mục khảo sát và câu hỏi
    const questionMap = {}; // Ánh xạ ch_id với vị trí cột
    let colIndex = 1;

    mucKhaoSat.forEach(mks => {
        // Tạo tiêu đề mục khảo sát
        const mksTh = document.createElement('th');
        mksTh.textContent = mks.ten_muc;
        headerRow.appendChild(mksTh);
        colIndex++;

        // Tìm các câu hỏi thuộc mục khảo sát này
        const relatedQuestions = cauHoi.filter(ch => ch.mks_id === mks.mks_id);
        relatedQuestions.forEach(ch => {
            const chTh = document.createElement('th');
            chTh.textContent = ch.noi_dung;
            headerRow.appendChild(chTh);
            questionMap[ch.ch_id] = colIndex;
            colIndex++;
        });
    });

    cauhoiList.appendChild(headerRow);

    // 7. Tạo nội dung bảng
    const traloiList = document.getElementById('traloi-list');
    traloiList.innerHTML = ''; // Xóa nội dung cũ

    // Tạo dữ liệu cho từng đối tượng
    const users = {};
    kqks.data.forEach(kq => {
        const dt = doiTuong.find(dt => dt.dt_id === kq.nguoi_lamks_id);
        if (dt) {
            users[kq.kqks_id] = { email: dt.email, answers: {} };
        }
    });

    // Gán câu trả lời vào users
    traLoi.forEach(tl => {
        const kq = kqks.data.find(kq => kq.kqks_id === tl.kq_ks_id);
        if (kq) {
            if (users[kq.kqks_id]) {
                users[kq.kqks_id].answers[tl.ch_id] = tl.ket_qua || '';
            }
        }
    });

    // Tạo hàng cho mỗi đối tượng
    Object.values(users).forEach(user => {
        const row = document.createElement('tr');

        // Cột Email
        const emailTd = document.createElement('td');
        emailTd.textContent = user.email;
        row.appendChild(emailTd);

        // Cột mục khảo sát (để trống)
        mucKhaoSat.forEach(mks => {
            const mksTd = document.createElement('td');
            row.appendChild(mksTd);

            // Cột câu hỏi
            const relatedQuestions = cauHoi.filter(ch => ch.mks_id === mks.mks_id);
            relatedQuestions.forEach(ch => {
                const answerTd = document.createElement('td');
                answerTd.textContent = user.answers[ch.ch_id] || '';
                row.appendChild(answerTd);
            })
        });




        traloiList.appendChild(row);
    });
}

function xuatExel(ks_id) {

}

$(document).ready(function () {
    const urlParams = new URLSearchParams(window.location.search);
    const ks_id = urlParams.get('id');
    console.log(ks_id);
    loadDuLieu(ks_id);

    $('#excel').on('click', function () {
        xuatExel(ks_id);
    });
});