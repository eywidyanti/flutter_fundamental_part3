// Part 1: Drag & drop files
document.addEventListener("DOMContentLoaded", event => {
    const fileDropzone = document.getElementById("file-dropzone");
    const output = document.getElementById("output");

    if (window.FileList && window.File) {
        fileDropzone.addEventListener("dragover", event => {
            event.stopPropagation();
            event.preventDefault();
            event.dataTransfer.dropEffect = "copy";
            fileDropzone.classList.add("dragover");
        });

        fileDropzone.addEventListener("dragleave", event => {
            fileDropzone.classList.remove("dragover");
        });

        fileDropzone.addEventListener("drop", event => {
            fileDropzone.classList.remove("dragover");
            event.stopPropagation();
            event.preventDefault();

            for (const file of event.dataTransfer.files) {
                const name = file.name;
                const size = file.size ? Math.round(file.size / 1000) : 0;

                if (file.type && file.type.startsWith("image/")) {
                    const li = document.createElement("li");
                    li.textContent = name + " (" + size + " KB)";
                    output.appendChild(li);
                }
            }
        });
    }
});

function dragMoveListener(event) {
    var target = event.target;
    var x = (parseFloat(target.getAttribute('data-x')) || 0) + event.dx;
    var y = (parseFloat(target.getAttribute('data-y')) || 0) + event.dy;

    target.style.transform = 'translate(' + x + 'px, ' + y + 'px)';
    target.setAttribute('data-x', x);
    target.setAttribute('data-y', y);
}

function onDragEnter(event) {
    var draggableElement = event.relatedTarget;
    var dropzoneElement = event.target;
    dropzoneElement.classList.add("drop-target");
    draggableElement.classList.add("can-drop");
}

function onDragLeave(event) {
    event.target.classList.remove("drop-target");
    event.relatedTarget.classList.remove("can-drop");
    console.log('keluar');
    const index = itemDrop.indexOf(event.relatedTarget.id);
    itemDrop.splice(index, 1);
    console.log(itemDrop);
}

function onDrop(event) {
    event.target.classList.remove("drop-target");
    console.log('masuk');
    if (!itemDrop.includes(event.relatedTarget.id)) {
        itemDrop.push(event.relatedTarget.id);
    }
    console.log(itemDrop);
}

document.addEventListener("DOMContentLoaded", event => {
    window.dragMoveListener = dragMoveListener;

    interact("#dropzone").dropzone({
        accept: ".itemA",
        overlap: 0.75,
        ondragenter: onDragEnter,
        ondragleave: onDragLeave,
        ondrop: onDrop
    });

    interact("#dropzoneA").dropzone({
        accept: ".itemA",
        overlap: 0.75,
        ondragenter: onDragEnter,
        ondragleave: onDragLeave,
        ondrop: onDrop
    });

    interact("#dropzoneB").dropzone({
        accept: ".itemB",
        overlap: 0.75,
        ondragenter: onDragEnter,
        ondragleave: onDragLeave,
        ondrop: onDrop
    });

    interact(".draggable").draggable({
        inertia: true,
        autoScroll: true,
        modifiers: [
            interact.modifiers.restrictRect({
                restriction: "parent",
                endOnly: true
            })
        ],
        listeners: {
            move: dragMoveListener
        }
    });
});
