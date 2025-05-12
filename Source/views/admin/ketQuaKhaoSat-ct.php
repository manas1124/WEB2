<div id="kqks-content" class="container h-full">
    <a href="" class="back-link btn btn-soft ">Quay lại</a>
    <div class="flex items-center justify-between mb-4">
        <h1>Kết quả khảo sát</h1>
        <div class="flex items-center gap-4">
            <button id="excel" class="btn btn-primary view-survey hidden">Xuất Excel</button>
        </div>
    </div>
    <div id="info-khaosat" class="mb-4 p-5 border rounded-lg shadow-md">
        <p class="mt-2 text-md font-medium text-gray-700"><strong>Tên bài khảo sát: </strong><span id="ks-ten"></span></p>
        <p class="mt-2 text-md font-medium text-gray-700"><strong>Thang điểm: </strong> <span id="ks-thangdiem"></span></p>
        <p class="mt-2 text-md font-medium text-gray-700"><strong>Ngày bắt đầu: </strong> <span id="ks-ngaybatdau"></span></p>
        <p class="mt-2 text-md font-medium text-gray-700"><strong>Ngày kết thúc: </strong> <span id="ks-ngayketthuc"></span></p>
        <p class="mt-2 text-md font-medium text-gray-700"><strong>Ngành: </strong> <span id="ks-nganh"></span></p>
        <p class="mt-2 text-md font-medium text-gray-700"><strong>Chu kỳ: </strong> <span id="ks-chuky"></span></p>
        <p class="mt-2 text-md font-medium text-gray-700"><strong>Nhóm khảo sát: </strong> <span id="ks-nhom"></span></p>
        <p class="mt-2 text-md font-medium text-gray-700"><strong>Số lượng tham gia khảo sát: </strong> <span id="ks-soluongthamgia"></span></p>
    </div>
    <div class="w-full overflow-x-auto">
        <table class="table">
            <thead id="cauhoi-list">
                <tr>
                    <th></th>
                </tr>
            </thead>
            <tbody id="traloi-list">
                <tr>

                </tr>
            </tbody>
        </table>
    </div>
</div>
<script src="./views/javascript/ketquakhaosat-xemkq.js"></script>