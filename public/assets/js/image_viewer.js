document.getElementById("image-close-button-circle").addEventListener("click", ()=>{
    let iv = document.getElementById("image-viewer");
    iv.classList.remove("open-image-viewer");
    iv.classList.add("close-image-viewer");
    cycle_notice = setInterval(next_notice,cycle_time);
});

function open_image_viewer(img){
    let image_src = img.src;
    let ivi = document.querySelector("#image-viewer-image > img");
    ivi.src = image_src;
    let iv = document.getElementById("image-viewer");
    iv.classList.remove("close-image-viewer");
    iv.classList.add("open-image-viewer");
    setTimeout(()=>{
        clearInterval(cycle_notice);
    },1000);
}