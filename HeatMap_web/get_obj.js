// เลือก DOM elements ที่เป็น draggables และ droppables
const draggables = document.querySelectorAll(".task");
const droppables = document.querySelectorAll(".swim-lane");


// เพิ่ม event listeners สำหรับ drag and drop ในทุก draggables
draggables.forEach((task) => {
  task.addEventListener("dragstart", (ev) => {
    task.classList.add("is-dragging");

  });
  task.addEventListener("dragend", (ev) => {
    task.classList.remove("is-dragging");
    // console.log(task.textContent + ' ==> '+ task.parentElement.textContent.split('\n')[1]);
    checktable();
  });
});

// เพิ่ม event listeners สำหรับ dragover ในทุก droppables
droppables.forEach((zone) => {
  zone.addEventListener("dragover", (e) => {
    e.preventDefault(); // หยุดการกระทำของ event เดิม
    
    const bottomTask = insertAboveTask(zone, e.clientY); // เรียกใช้ฟังก์ชัน insertAboveTask เพื่อหา task ที่อยู่ด้านล่างสุด
    const curTask = document.querySelector(".is-dragging"); // หา DOM element ที่กำลังถูกลาก
    const parentZone = curTask.parentElement; // หา parent element ของ curTask


    if (!bottomTask) { // ถ้าไม่มี task ที่อยู่ด้านล่างของ zone
      zone.appendChild(curTask); // เพิ่ม curTask เป็น child ของ zone
    } else { // ถ้ามี task ที่อยู่ด้านล่างของ zone
      zone.insertBefore(curTask, bottomTask); // เพิ่ม curTask เป็น sibling ก่อน bottomTask
    }

    if (parentZone === zone) { // ถ้า curTask อยู่ใน zone เดียวกันกับที่วางลงไป

    } else { // ถ้า curTask ไม่ได้อยู่ใน zone เดียวกันกับที่วางลงไป

    }
  });
});

// ฟังก์ชันสำหรับหา task ที่อยู่ด้านล่างสุดใน zone โดยอ้างอิงจากตำแหน่งของเม้าส์
const insertAboveTask = (zone, mouseY) => {
  const els = zone.querySelectorAll(".task:not(.is-dragging)");

  let closestTask = null;
  let closestOffset = Number.NEGATIVE_INFINITY;

  els.forEach((task) => {
    const { top } = task.getBoundingClientRect(); // หาค่า top ของ task
    const offset = mouseY - top; // คำนวณหาค่า offset ของ task ที่อยู่ใกล้ที่สุดกับเม้าส์

    if (offset < 0 && offset > closestOffset) { // ถ้า offset น้อยกว่า 0 และมากกว่า closestOffset
      closestOffset = offset;
      closestTask = task;
    }

  });
  return closestTask;
};

function checktable () {
  var tasks = document.querySelectorAll(".swim-lane");
  tasks.forEach((task) => {
    //  foreach "tasks" เพื่อหาว่าในนั้นมีอะไรอยู่บ้าง
    var taskhead = task.textContent; // เอาแค่ส่วน text ที่ได้เขียนไป (<>text</>)
    var arTask = taskhead.replace(/([a-z])([A-Z])/g, '$1\n$2').split('\n') // ทำให้มีการเว้นบรรทัน เพื่อไม่ให้มันติดกัน
    var cuttask = arTask.slice(2).map((item) => item.trim()).join(', '); // เลือกตัวที่ 2 เป็นต้อนไป แล้วทำให้มันมีการเว้นด้วย ,
    var headdingRole = taskhead.split('\n')[1].trim() // เอาเฉพราะหัวข้อที่ index 1 ของ teskhead มา 
    
    // สร้าง list ไว้เก็บค่า ที่เมื่อปุ่มไปอยู๋ใน ช่องต่างๆ
    var rank1_obj = []
    var rank2_obj = []
    var rank3_obj = []

    // เช็คว่ามี button role ไปอยู่ ในช่องไหนบ้าง แล้ว add เข้า list
    if (headdingRole === 'Rank 1'){   
      rank1_obj = [cuttask]

      var xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          console.log(this.responseText);
        }
      };
      // Send to the PHP script
      var form_data = new FormData();

      form_data.append("rank1_obj", rank1_obj);
      xhttp.open("GET", "ranking_gen.php?rank1_obj="+rank1_obj, true);
      xhttp.send();
      console.log('send_form_data completed')
    }
    if (headdingRole === 'Rank 2'){   
      rank2_obj = [cuttask]

      var xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          console.log(this.responseText);
        }
      };
      // Send to the PHP script
      var form_data = new FormData();

      form_data.append("rank2_obj", rank2_obj);
      xhttp.open("GET", "ranking_gen.php?rank2_obj="+rank2_obj, true);
      xhttp.send();
      console.log('send_form_data completed')
    }
    if (headdingRole === 'Rank 3'){
      rank3_obj = [cuttask]

      var xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          console.log(this.responseText);
        }
      };
      // Send to the PHP script
      var form_data = new FormData();

      form_data.append("rank3_obj", rank3_obj);
      xhttp.open("GET", "ranking_gen.php?rank3_obj="+rank3_obj, true);
      xhttp.send();
      console.log('send_form_data completed')
    }
    if (headdingRole === 'Role') {
      
    }
    
    
    
  });

}

function updatepopup(text) {
  var popup = document.querySelectorAll('div.popup')
}

