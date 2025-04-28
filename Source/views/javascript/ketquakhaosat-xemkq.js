async function getAllMucKhaoSat(ks_id){
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
async function getAllCauHoi(mks_ids){
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
async function getAllKqks(page = 1, ks_id = null) {
    try {
        const response = await $.ajax({
            url: "./controller/ketQuaKhaoSatController.php",
            type: "GET",
            dataType: "json",
            data: {
                func: "getAllByKsId",
                page: page,
                ks_id: ks_id
            },
        });
        return response;
    } catch (error) {
        console.error(error);
        return null;
    }
}
async function getAllDoiTuong(doiTuong_ids){
    try {
        const response = await $.ajax({
            url: "./controller/ketQuaKhaoSatController.php",
            type: "GET",
            dataType: "json",
            data: {
                func: "getByIds",
                dt_ids: doiTuong_ids
            },
        });
        return response;
    } catch (error) {
        console.error(error);
        return null;
    }
}
async function getAllTraLoi(kqks){
    try {
        const response = await $.ajax({
            url: "./controller/.php",
            type: "GET",
            dataType: "json",
            data: {
                func: ""
            },
        });
        return response;
    } catch (error) {
        console.error(error);
        return null;
    }
}

async function loadCauHoi(ks_id){
    const mucKhaoSat = await getAllMucKhaoSat(ks_id);
    const mks_ids = mucKhaoSat.map(item => item.mks_id);
    const cauHoi = await getAllCauHoi(mks_ids);
    console.log(mucKhaoSat);
    console.log(cauHoi);
}

async function loadKetQuaKs(ks_id){

    const kqks = await getAllKqks(1, ks_id);
    const doiTuong_ids = kqks.data.map(item => item.nguoi_lamks_id);
    const doiTuong = await getAllDoiTuong(doiTuong_ids);
    // const traLoi = await getAllTraLoi(kqks, cauHoi);

    console.log(kqks);
    console.log(doiTuong);
    // console.log(traLoi);
}

$(document).ready(function() {
    const urlParams = new URLSearchParams(window.location.search);
    const ks_id = urlParams.get('id');
    console.log(ks_id);
    loadCauHoi(ks_id);
    loadKetQuaKs(ks_id);
});