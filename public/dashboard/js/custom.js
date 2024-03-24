                //work in edit
                // function showImage(src) {
                // let parent = document.getElementById("parent");
                // let imageDiv = document.getElementById("image-div");
                // let target = document.getElementById("imageTag");
                // src.addEventListener("change",function(e) {
                //     imageDiv.innerHTML = '';
                //     let count = e.target.files.length;
                //     for (let i = 0; i < count; i++) {
                //         let image  = document.createElement('img');
                //         image.setAttribute('class', 'selected-image');
                //         imageDiv.appendChild(image);
                //         let fr=new FileReader();
                //         fr.readAsDataURL(e.target.files[i]);
                //         fr.onload = function(e) { image.src = this.result };
                //         // let rmImage = document.getElementById("rmImage").classList.remove('hidden');
                //         let rmImage = document.getElementById("rmImage");
                //         imageDiv.appendChild(rmImage);
                //         rmImage = document.getElementById("rmImage").classList.remove('hidden');

                //     }
                // });
                // }
                // var src = document.getElementById("fileInput");
                // showImage(src);

                //work in create status
                function showImage(src) {
                    let parent = document.getElementById("parent");
                    // let imageDiv = document.getElementById("image-div");
                    let target = document.getElementById("imageTag");
                    src.addEventListener("change",function(e) {
                        parent.innerHTML = '';
                        let count = e.target.files.length;
                        for (let i = 0; i < count; i++) {
                            let image  = document.createElement('img');//create html image tag
                            let imageDiv  = document.createElement('div');//create html div tag
                            image.setAttribute('class', 'selected-image');//add css class to image
                            imageDiv.setAttribute('class', 'image-div');//add css class to image div
                            imageDiv.appendChild(image);// put the image in new div
                            parent.appendChild(imageDiv);// put the new dev in parent div
                            let currentUrl = window.location.href;

                            // if (currentUrl.includes('edit')){//check if  url has  edit word
                                let btnDelete = document.createElement('button');
                                btnDelete.setAttribute('class','btn btn-danger btn-sm btn-rm-image');
                                btnDelete.textContent = 'x' + i;

                                imageDiv.appendChild(btnDelete);
                                let fr=new FileReader();
                            fr.readAsDataURL(e.target.files[i]);
                            fr.onload = function(e) { image.src = this.result };
                                btnDelete.onclick = function(event){
                                    event.preventDefault();
                                    // removeFileFromFileList(i,src)
                                    const dt = new DataTransfer()
                                    const { files } = src;
                                    console.log('this is i :' + i);
                                    for (let j = 0; j < files.length; j++) {
                                        
                                        const file = files[j];
                                        if (i !== j)
                                        dt.items.add(file) // here you exclude the file. thus removing it.
                                    }
                                    src.files = dt.files // Assign the updates list
                                    this.parentElement.style.display='none';
                                }

                            // }
                            
                        }
                    });
                    }
                    let src = document.getElementById("fileInput");
                    showImage(src);


                    function removeFileFromFileList(index, input) {
                        const dt = new DataTransfer()
                        const { files } = input
                        for (let i = 0; i < files.length; i++) {
                            const file = files[i]
                            if (index !== i)
                            dt.items.add(file) // here you exclude the file. thus removing it.
                        }
                        input.files = dt.files // Assign the updates list
                    }


