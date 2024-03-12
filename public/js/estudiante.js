$(document).on("click","#btn_student_search",function(){
	const est_id=$("#est_id").val();
	const token=$("input[name=_token]").val();
	const url=window.location;
  axios.post(url+'/search_student', {est_id: est_id}, 
  {
    headers: {
      'Authorization': 'Bearer ' + token
    }
  })
  .then(function (response) {
    const estudiantes=response.data;
    let dt="";
    let c=0;
    estudiantes.forEach((est)=>{
    	c++;
    	dt+=`<tr>
    	         <td>${c}</td>
    	         <td>${est.est_cedula} ${est.est_apellidos} ${est.est_nombres}</td>
    	         <td>${est.anl_descripcion} ${est.jor_descripcion} ${est.esp_descripcion} ${est.cur_descripcion} ${est.mat_paralelo}</td>
    	         <td>
    	            <span 
    	            mat_id="${est.mat_id}" 
    	            est_cedula="${est.est_cedula}"
    	            estudiante="${est.est_apellidos} ${est.est_nombres}"
    	            anl_descripcion="${est.anl_descripcion}"
    	            jor_descripcion="${est.jor_descripcion}"
    	            esp_descripcion="${est.esp_descripcion}"
    	            cur_descripcion="${est.cur_descripcion}"
    	            mat_paralelo="${est.mat_paralelo}"
    	            class="btn btn-success btn-xs btn_select_student p-2" >&#x2713;</span>
    	         </td>
    	     </tr>`;
    });
    $("#tbl_estudiantes").html(dt);
    $("#mdl_search_student").modal("show");
  })
  .catch(function (error) {
    console.log(error);
  });


})

$(document).on("click",".btn_select_student",function(){
     const mat_id=$(this).attr("mat_id");
     const est_cedula=$(this).attr("est_cedula");
     const estudiante=$(this).attr("estudiante");
     const anl_descripcion=$(this).attr("anl_descripcion");
     const jor_descripcion=$(this).attr("jor_descripcion");
     const esp_descripcion=$(this).attr("esp_descripcion");
     const cur_descripcion=$(this).attr("cur_descripcion");
     const mat_paralelo=$(this).attr("mat_paralelo");

     $("#mat_id").val(mat_id);
     $("#mdl_search_student").modal("hide");

     $("#cont_datos_est").html(`
         <div>
     	    <span class='text-left'> <strong>Cédula:</strong> ${est_cedula} </span>	
     	    <span class='text-left'> <strong>Estudiante:</strong> ${estudiante} </span>	
         </div>   	
         <div>
     	    <span class='text-left'> <strong>Año Lectivo:</strong> ${anl_descripcion} </span>	
     	    <span class='text-left'> <strong>Jornada:</strong> ${jor_descripcion} </span>	
         </div>   	
         <div>
     	    <span class='text-left'> <strong>Especialidad:</strong> ${esp_descripcion} </span>	
     	    <span class='text-left'> <strong>Curso:</strong> ${cur_descripcion} ${mat_paralelo} </span>	
         </div>   	
     	`);
})