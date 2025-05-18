async function getKhaoSatById(ks_id) {
    try {
        const response = await $.ajax({
            url: "./controller/KhaoSatController.php",
            type: "POSt",
            dataType: "json",
            data: {
                func: "getChiTietKsById",
                id: ks_id
            },
        });
        return response;
    } catch (error) {
        console.error(error);
        return null;
    }
}

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

async function getAllLoaidt() {
    try {
        const response = await $.ajax({
            url: "./controller/LoaidtController.php",
            type: "GET",
            data: { func: "getAllLoaidt" },
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

async function getUserByIds(dt_ids) {
    try {
        const response = await $.ajax({

            url: "./controller/doiTuongController.php",
            type: "GET",
            data: { func: "getByIds", dt_ids: dt_ids },
            dataType: "json",
        });
        console.log(" Phản hồi getUserById:", response);

        return response;
    } catch (error) {
        console.log("Lỗi khi lấy dữ liệu người dùng", error);
        return null;
    }
}

async function loadDuLieu(ks_id) {

    // 0. Lấy chi tiết khảo sát
    const khaoSat = await getKhaoSatById(ks_id);
    if (khaoSat?.status === false && khaoSat?.message) {
        Swal.fire({
            title: "Thông báo",
            text: khaoSat.message,
            icon: "warning"
        });
        return;
    }

    document.getElementById('ks-ten').textContent = khaoSat.ten_ks || 'Không rõ';
    document.getElementById('ks-thangdiem').textContent = khaoSat.thang_diem || 'Chưa có';
    document.getElementById('ks-ngaybatdau').textContent = khaoSat.ngay_bat_dau || 'Chưa có';
    document.getElementById('ks-ngayketthuc').textContent = khaoSat.ngay_ket_thuc || 'Chưa có';
    document.getElementById('ks-nganh').textContent = khaoSat.ten_nganh || 'Chưa có';
    document.getElementById('ks-chuky').textContent = khaoSat.ten_ck || 'Chưa có';
    document.getElementById('ks-nhom').textContent = khaoSat.ten_nks || 'Chưa có';

    // 1. Lấy danh sách mục khảo sát
    const mucKhaoSat = await getAllMucKhaoSat(ks_id);
    const mks_ids = mucKhaoSat.map(item => item.mks_id);

    // 2. Lấy danh sách câu hỏi theo mks_ids
    const cauHoi = await getAllCauHoi(mks_ids);

    // 3. Lấy kết quả khảo sát
    const kqks = await getAllKqks(ks_id);
    const kqks_ids = kqks.data.map(item => item.kqks_id);
    const doiTuong_Ids = kqks.data.map(item => item.nguoi_lamks_id);

    const loaiDoiTuongs = await getAllLoaidt();
    const doiTuongs = await getUserByIds(doiTuong_Ids);

    console.log(loaiDoiTuongs);
    console.log(doiTuongs);


    document.getElementById('ks-soluongthamgia').textContent = kqks_ids.length || 'Chưa có';

    // 4. Lấy danh sách trả lời
    const traLoi = await getAllTraLoi(kqks_ids);

    console.log(mucKhaoSat);
    console.log(cauHoi);
    console.log(kqks.data);
    console.log(traLoi);

    const ltlContainer = document.getElementById("ltl-container");

    const chitiet_mota = khaoSat.ltl_chitiet_mota ? khaoSat.ltl_chitiet_mota.split(",").map(item => item.trim()) : null;
    chitiet_mota.forEach((item, index) => {
        const section = document.createElement("div");
        section.className = `p-4 section min-w-[125px] min-h-[125px] rounded-full item-center`;
        section.innerHTML = `
                    <div>
                        <h3 class='mt-3 text-center'>${index + 1}</h3>
                    </div>
                    <div>
                        <p class='mt-3 text-center'>${item}</p>
                    </div>
                `;
        ltlContainer.appendChild(section);
    });

    // 5. Tạo nội dung bảng
    const ketQuaList = document.getElementById('ketqua-list');
    ketQuaList.innerHTML = '';

    // Gom dữ liệu vào Map như trước
    const mksTheoCha = new Map();
    mucKhaoSat.forEach(mks => {
        const parentId = mks.parent_mks_id || 'root';
        if (!mksTheoCha.has(parentId)) {
            mksTheoCha.set(parentId, []);
        }
        mksTheoCha.get(parentId).push(mks);
    });

    const cauHoiTheoMks = new Map();
    cauHoi.forEach(ch => {
        if (!cauHoiTheoMks.has(ch.mks_id)) {
            cauHoiTheoMks.set(ch.mks_id, []);
        }
        cauHoiTheoMks.get(ch.mks_id).push(ch);
    });

    const traLoiTheoCauHoi = new Map();
    traLoi.forEach(tl => {
        const key = `${tl.ch_id}-${tl.ket_qua}`;
        traLoiTheoCauHoi.set(key, (traLoiTheoCauHoi.get(key) || 0) + 1);
    });

    function taoDongCauHoi(ch, prefix = '') {
        const row = document.createElement('tr');
        row.classList.add('hover');

        const cauHoiTd = document.createElement('td');
        cauHoiTd.textContent = `${prefix} ${ch.noi_dung}`;
        row.appendChild(cauHoiTd);

        for (let diem = 1; diem <= khaoSat.thang_diem; diem++) {
            const count = traLoiTheoCauHoi.get(`${ch.ch_id}-${diem}`) || 0;
            const td = document.createElement('td');
            td.textContent = count;
            td.classList.add("text-center");
            row.appendChild(td);
        }

        return row;
    }

    // Duyệt các mục cha
    const mucChaList = mksTheoCha.get('root') || [];
    mucChaList.forEach((mucCha, indexMuc) => {
        // Tạo tiêu đề cho mục cha
        const tieude = document.createElement('h3');
        tieude.textContent = mucCha.ten_muc;
        tieude.style.marginTop = '30px';
        tieude.style.fontWeight = 'bold';
        ketQuaList.appendChild(tieude);

        // Tạo bảng mới
        const tableContainer = document.createElement('div');
        const table = document.createElement('table');
        table.classList.add('table', 'table-striped', 'w-full', 'mb-4', 'border-collapse', 'border', 'border-black', 'mt-2');

        // Header bảng
        const thead = document.createElement('thead');
        const headRow1 = document.createElement('tr');
        headRow1.innerHTML = `<th rowspan=2 class="border border-black">Nội dung</th>
                              <th class="text-center border border-black" colspan=${khaoSat.thang_diem}>${khaoSat.ltl_mota}</th>`;
        thead.appendChild(headRow1);
        const headRow2 = document.createElement('tr');
        headRow2.innerHTML = Array.from({ length: khaoSat.thang_diem }, (_, i) => `<th class="text-center border border-black">${i + 1}</th>`).join('');
        thead.appendChild(headRow2);
        table.appendChild(thead);

        // Body bảng
        const tbody = document.createElement('tbody');
        table.appendChild(tbody);

        const mucConList = mksTheoCha.get(mucCha.mks_id) || [];

        if (mucConList.length > 0) {
            // Có mục con
            mucConList.forEach(mucCon => {
                const row = document.createElement('tr');
                const td = document.createElement('td');
                td.textContent = `${indexMuc + 1}. ${mucCon.ten_muc}`;
                td.colSpan = khaoSat.thang_diem + 1;
                td.style.fontWeight = 'bold';
                td.style.paddingLeft = '10px';
                row.appendChild(td);
                tbody.appendChild(row);

                const relatedQuestions = cauHoiTheoMks.get(mucCon.mks_id) || [];
                relatedQuestions.forEach((ch, indexCH) => {
                    tbody.appendChild(taoDongCauHoi(ch, `${indexMuc + 1}.${indexCH + 1}.`));
                });
            });
        } else {
            // Không có mục con → render trực tiếp câu hỏi
            const relatedQuestions = cauHoiTheoMks.get(mucCha.mks_id) || [];
            relatedQuestions.forEach((ch, indexCH) => {
                tbody.appendChild(taoDongCauHoi(ch, `${indexMuc + 1}.${indexCH + 1}.`));
            });
        }
        tableContainer.appendChild(table);
        ketQuaList.appendChild(tableContainer);
    });

}

function xuatExel(ks_id) {
    Swal.fire({
        title: 'Đang xử lý...',
        text: 'Vui lòng chờ trong giây lát',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });
    $.ajax({
        url: './controller/ketQuaKhaoSatController.php',
        type: 'GET',
        data: {
            func: "xuatExel",
            ks_id: ks_id
        },
        xhrFields: {
            responseType: 'blob'
        },
        success: function (response) {
            Swal.close();
            if (response?.status === false && response?.message) {
                Swal.fire({
                    title: "Thông báo",
                    text: response.message,
                    icon: "warning"
                });
            } else {
                var blob = new Blob([response], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
                var link = document.createElement('a');
                link.href = URL.createObjectURL(blob);
                link.download = `survey_export_${ks_id}.xlsx`;
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            }
        },
        error: function (xhr, status, error) {
            console.error("Đã xảy ra lỗi khi xuất Excel:", error);
        }
    });
}

function printDiv() {
    var divContents = document.getElementById("print-content").innerHTML;
    var printWindow = window.open('', '', 'height=600,width=800');

    // Lấy toàn bộ thẻ <style> và <link> từ trang gốc
    var styles = '';
    document.querySelectorAll('link[rel="stylesheet"], style').forEach((style) => {
        styles += style.outerHTML;
    });

    printWindow.document.write('<html>');
    printWindow.document.write('<head><title>In nội dung</title>' + styles + '</head>');
    printWindow.document.write('<body>');
    printWindow.document.write('<div>' + divContents + '</div>');
    printWindow.document.write('</body></html>');
    printWindow.document.close();

    printWindow.onload = function () {
        printWindow.focus();
        printWindow.print();
        printWindow.close();
    };
}

$(document).ready(function () {
    const urlParams = new URLSearchParams(window.location.search);
    const ks_id = urlParams.get('id');
    console.log(ks_id);
    loadDuLieu(ks_id);

    $('#excel').on('click', function () {
        xuatExel(ks_id);
    });

    $('#pdf').on('click', function () {
        printDiv();
    });
});