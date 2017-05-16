(function() {

    var db = {

        loadData: function(filter) {
            return $.grep(this.courses, function(course) {
                return (!filter.No || course.No.indexOf(filter.No) > -1)
                    && (!filter.id || course.id === filter.id)
                    &&(!filter.FullName || course.FullName.indexOf(filter.FullName) > -1)
                    &&(!filter.visible || course.visible.indexOf(filter.visible) > -1)
                    &&(!filter.total_grupox || course.total_grupox.indexOf(filter.total_grupox) > -1)
                    &&(!filter.total_tutores || course.total_tutores.indexOf(filter.total_tutores) > -1)
                    &&(!filter.startdate || course.startdate.indexOf(filter.startdate) > -1)
                    &&(!filter.subsanacion || course.subsanacion.indexOf(filter.subsanacion) > -1)
                    &&(!filter.subsanacion_de || course.subsanacion_de.indexOf(filter.subsanacion_de) > -1)
                    &&(!filter.inscritos || course.inscritos.indexOf(filter.inscritos) > -1)
                    &&(!filter.reti_sinfo || course.reti_sinfo.indexOf(filter.reti_sinfo) > -1)
                    &&(!filter.pondera || course.pondera.indexOf(filter.pondera) > -1)
                    &&(!filter.patron || course.patron.indexOf(filter.patron) > -1)
                    &&(!filter.temas_foro || course.temas_foro.indexOf(filter.temas_foro) > -1)
                    &&(!filter.hacademica || course.hacademica.indexOf(filter.hacademica) > -1)
                    &&(!filter.periodo || course.periodo.indexOf(filter.periodo) > -1)
                    &&(!filter.presencial || course.presencial.indexOf(filter.presencial) > -1)
                   
            });
        },
        insertItem: function(insertingCourse) {
            this.courses.push(insertingCourse);
        },
        updateItem: function(updatingCourse) { },

        deleteItem: function(deletingCourse) {
            var clientIndex = $.inArray(deletingCourses, this.courses);
            this.courses.splice(clientIndex, 1);
        }
    }; 

    window.db = db;

    db.courses = [
        {
            "No": 1,
            "id": 7412,
			"fullname": 'Técnicas de la comunicación escrita (TECE) -  201710 - Grupo B - ZONAL LIMA CALLAO',
			"visible": 0,
			"total_grupox": 13,
			"total_tutores": 0,
			"startdate": '10/10/2017',
			"subsanacion": 's',
			"subsanacion_de": 3,
			"inscritos": 20,
			"reti_sinfo": 0,
			"pondera": 1,
			"patron": 's',
			"temas_foro": 0,
			"hacademica": 0,
			"periodo": '201710',
			"presencial": 'n'
			
        },
		{
            "No": 1,
            "id": 7412,
			"fullname": 'Técnicas de la comunicación escrita (TECE) -  201710 - Grupo B - ZONAL LIMA CALLAO',
			"visible": 0,
			"total_grupox": 2,
			"total_tutores": 20,
			"startdate": '10/10/2017',
			"subsanacion": 'n',
			"subsanacion_de": 3,
			"inscritos": 0,
			"reti_sinfo": 1,
			"pondera": 0,
			"patron": 'f',
			"temas_foro": 23,
			"hacademica": 1,
			"periodo": '201710',
			"presencial": 's'
        },
		{
            "No": 1,
            "id": 7412,
			"fullname": 'Técnicas de la comunicación escrita (TECE) -  201710 - Grupo B - ZONAL LIMA CALLAO',
			"visible": 1,
			"total_grupox": 13,
			"total_tutores": 0,
			"startdate": '10/10/2017',
			"subsanacion": 'n',
			"subsanacion_de": 3,
			"inscritos": 0,
			"reti_sinfo": 1,
			"pondera": 0,
			"patron": 's',
			"temas_foro": 72,
			"hacademica": 1,
			"periodo": '201710',
			"presencial": 's'
        },
		{
            "No": 1,
            "id": 7412,
			"fullname": 'Técnicas de la comunicación escrita (TECE) -  201710 - Grupo B - ZONAL LIMA CALLAO',
			"visible": 1,
			"total_grupox": 13,
			"total_tutores": 20,
			"startdate": '10/10/2017',
			"subsanacion": 's',
			"subsanacion_de": 3,
			"inscritos": 20,
			"reti_sinfo": 0,
			"pondera": 1,
			"patron": 's',
			"temas_foro": 72,
			"hacademica": 0,
			"periodo": '201710',
			"presencial": 'n'
        },
		{
           "No": 1,
            "id": 7412,
			"fullname": 'Técnicas de la comunicación escrita (TECE) -  201710 - Grupo B - ZONAL LIMA CALLAO',
			"visible": 1,
			"total_grupox": 13,
			"total_tutores": 2,
			"startdate": '10/10/2017',
			"subsanacion": 's',
			"subsanacion_de": 3,
			"inscritos": 0,
			"reti_sinfo": 0,
			"pondera": 1,
			"patron": 'f',
			"temas_foro": 72,
			"hacademica": 1,
			"periodo": '201710',
			"presencial": 's'
        },
		{
           "No": 1,
            "id": 7412,
			"fullname": 'Técnicas de la comunicación escrita (TECE) -  201710 - Grupo B - ZONAL LIMA CALLAO',
			"visible": 1,
			"total_grupox": 13,
			"total_tutores": 2,
			"startdate": '10/10/2017',
			"subsanacion": '',
			"subsanacion_de": 3,
			"inscritos": 0,
			"reti_sinfo": 0,
			"pondera": 1,
			"patron": 'f',
			"temas_foro": 72,
			"hacademica": 1,
			"periodo": '201710',
			"presencial": ''
        }  	
		
    ];


   /*

    db.countries = [
        { Name: "", Id: 0 },
        { Name: "United States", Id: 1 },
        { Name: "Canada", Id: 2 },
        { Name: "United Kingdom", Id: 3 },
        { Name: "France", Id: 4 },
        { Name: "Brazil", Id: 5 },
        { Name: "China", Id: 6 },
        { Name: "Russia", Id: 7 }
    ]; 

    */
   

}());