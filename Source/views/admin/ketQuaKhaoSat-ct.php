<div id="kqks-content" class="container h-full">

    <div class="flex items-center justify-between mb-4">
        <div class="flex items-center gap-4">
            <a href="" class="back-link btn btn-soft ">Quay lại</a>
        </div>
        <div class="flex items-center gap-4">
            <div>
                <button id="excel" class="btn btn-primary view-survey hidden">Xuất Excel</button>
            </div>
            <div>
                <button id="pdf" class="btn btn-primary view-survey hidden">Xuất Báo cáo</button>
            </div>
        </div>

    </div>
    <div id="print-content">
        <div id="info-khaosat" class="mb-4 p-5 border rounded-lg shadow-md">
            <div class="w-full flex flex-wrap wrap justify-center">
                <p class="text-[20px] font-bold">Thông tin bài khảo sát</p>
            </div>
            <div class="w-full flex flex-wrap wrap justify-between md:justify-around">
                <div>
                    <p class="mt-2 text-md font-medium text-gray-700"><strong>Tên bài khảo sát: </strong><span id="ks-ten"></span></p>
                    <p class="mt-2 text-md font-medium text-gray-700"><strong>Ngày bắt đầu: </strong> <span id="ks-ngaybatdau"></span></p>
                    <p class="mt-2 text-md font-medium text-gray-700"><strong>Ngày kết thúc: </strong> <span id="ks-ngayketthuc"></span></p>
                </div>
                <div>
                    <p class="mt-2 text-md font-medium text-gray-700"><strong>Ngành: </strong> <span id="ks-nganh"></span></p>
                    <p class="mt-2 text-md font-medium text-gray-700"><strong>Chu kỳ: </strong> <span id="ks-chuky"></span></p>
                    <p class="mt-2 text-md font-medium text-gray-700"><strong>Nhóm khảo sát: </strong> <span id="ks-nhom"></span></p>
                </div>
            </div>
        </div>
        <div class="mb-4 p-5 border rounded-lg shadow-md">
            <p class="mt-2 text-md font-medium text-gray-700"><strong>Số lượng tham gia khảo sát: </strong> <span id="ks-soluongthamgia"></span></p>
        </div>
    </div>
    <div class="fles flex-col">
        <div>
            <p class="mt-2 text-md font-medium text-gray-700"><strong>Thang điểm: </strong> <span id="ks-thangdiem"></span></p>
        </div>
        <div class="w-full flex flex-wrap wrap justify-center gap-4" id="ltl-container">

        </div>
    </div>
    <div class="w-full overflow-x-auto">
        <div class="flex flex-col" id="ketqua-list">

        </div>
    </div>
</div>
<script src="./views/javascript/ketquakhaosat-xemkq.js"></script>