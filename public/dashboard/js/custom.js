                function showImage(src,target) {
                var fr=new FileReader();
                // when image is loaded, set the src of the image where you want to display it
                src.addEventListener("change",function(e) {
                    // fill fr with image data
                    fr.readAsDataURL(e.target.files[0]);
                    var target = document.getElementById("imageDev").classList.remove('hidden');
                });
                fr.onload = function(e) { target.src = this.result };
                }
                var src = document.getElementById("fileInput");
                var target = document.getElementById("imageDev");
                showImage(src,target);
