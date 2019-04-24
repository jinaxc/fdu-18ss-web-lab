window.onload = function(){
    function changePicture(){
        let thumbNails = document.querySelector("#thumbnails");
        let featuredImage = document.querySelector("#featured img");
        thumbNails.addEventListener("click",function(e){
            let imageClicked = e.target;
            let figCaption = document.querySelector("figcaption");
            let imageClickedPath = getPath(imageClicked.src.toString());
            let featuredImagePath = getPath(featuredImage.src.toString());
            if(imageClickedPath !== featuredImagePath){
                featuredImage.src = `images/medium/${imageClickedPath}`;
                featuredImage.title = imageClicked.title.toString();
                figCaption.innerHTML = imageClicked.title.toString();
            }
        })
        function getPath(imageSrc){
            let reg = /[0-9]+\.jpg$/;
            let path = reg.exec(imageSrc).toString(); 
            return path;
        }
    }
    changePicture();
    function showAndHideCaption(){
        let figure = document.querySelector("figure");
        let figCaption = document.querySelector("figcaption");
        let isChangingOpacity = false;
        let t = null;
        figure.addEventListener("mouseover",function(e){
            if(isChangingOpacity && t != null){
                clearInterval(t);
            }
            isChangingOpacity = true;
            let opacity = (figCaption.style.opacity !== "" && figCaption.style.opacity > 0)  ? figCaption.style.opacity : 0;
            function changeOpacity(){
                if(opacity >= 0.8){
                    clearInterval(t);
                    isChangingOpacity = false;
                }
            
                figCaption.style.opacity = opacity;     
                opacity = parseFloat(opacity) + 0.01;
            
            }
            t = setInterval(changeOpacity,1000 / 80);
        })
        document.addEventListener("mouseout",function(e){
            if(isChangingOpacity && t != null){
                clearInterval(t);
            }
            isChangingOpacity = true;
            let opacity = (figCaption.style.opacity !== "" && figCaption.style.opacity < 0.8) ? figCaption.style.opacity : 0.8;
            function changeOpacity(){
                if(opacity <= 0){
                    clearInterval(t);
                    isChangingOpacity = false;
                }
                figCaption.style.opacity = opacity;
                opacity = parseFloat(opacity) - 0.01;
            }
            t = setInterval(changeOpacity,1000 / 80);
        })
    }
    showAndHideCaption();
}