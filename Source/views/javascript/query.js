async function getCurrentLoginUser() {
    try {
      const response = await $.ajax({
        url: "./controller/AuthController.php",
        type: "POST",
        dataType: "json",
        data: { func :"getCurrentLoginUser"},
      });
      if (response.status == 'error') {
        alert(response.message)
        return null;
      }
      return response;
    } catch (error) {
      console.error(error);
      return null;
    }
  }