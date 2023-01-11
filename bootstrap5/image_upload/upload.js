(function () {
  var input = document.getElementById("inpt_upload"),
      formdata = false;
    
  if (window.FormData) {
    formdata = new FormData();
    document.getElementById("btn").style.display = "none";
  }
  
function showUploadedItem (source) {
  var list = document.getElementById("image-list"),
      li   = document.createElement("li"),
      img  = document.createElement("img");
    img.src = source;
    li.appendChild(img);
  list.appendChild(li);
}

if (input.addEventListener) {
    input.addEventListener("change", function (evt) {
    var i = 0, len = this.files.length, img, reader, file;
    
    document.getElementById("response").innerHTML = "Uploading . . ."
    
        for ( ; i < len; i++ ) {
          file = this.files[i];

            //if (!!file.type.match(/image.*/)) {
                if ( window.FileReader ) {
                    reader = new FileReader();
                    reader.onloadend = function (e) { 
                      //showUploadedItem(e.target.result);
                    };
                    reader.readAsDataURL(file);
                }
                if (formdata) {
                    formdata.append("inpt_upload[]", file);
                }
            //}
        }
        
        if (formdata) {
            $.ajax({
                url: "upload.php",
                type: "POST",
                data: formdata,
                processData: false,
                contentType: false,
                success: function (response) {
                    document.getElementById("response").innerHTML = ''; 
                    document.getElementById("inpt_upload").value = "";
                    formdata = new FormData();
                    load_chat(response)
                }
            });
        }
      
    }, false);
}

}());