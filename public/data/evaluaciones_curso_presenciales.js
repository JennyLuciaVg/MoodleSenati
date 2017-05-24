(function() {

    var db = {

        loadData: function(filter) {
            return $.grep(this.evaluaciones, function(ponderaciones) {
                return (!filter.tareas || ponderaciones.tareas.indexOf(filter.tareas) > -1)
                    && (!filter.ponderado_tareas || ponderaciones.ponderado_tareas > -1)
                    && (!filter.unidad_tarea || ponderaciones.unidad_tarea.indexOf(filter.unidad_tarea) > -1)
                    && (!filter.cuestionarios || ponderaciones.cuestionarios.indexOf(filter.cuestionarios) > -1)
                    && (!filter.ponderado_cuestionario || ponderaciones.ponderado_cuestionario.indexOf(filter.ponderado_cuestionario) > -1)
                    && (!filter.unidad_cuestionario || ponderaciones.unidad_cuestionario.indexOf(filter.unidad_cuestionario) > -1)
                    && (!filter.foros || ponderaciones.foros.indexOf(filter.foros) > -1)
                    && (!filter.ponderado_foros || ponderaciones.ponderado_foros.indexOf(filter.ponderado_foros) > -1)
                    && (!filter.unidad_foros || ponderaciones.unidad_foros.indexOf(filter.unidad_foros) > -1)
            });
        },
        insertItem: function(insertingCourse) {
            this.evaluaciones.push(insertingCourse);
        },
        updateItem: function(updatingCourse) { },

        deleteItem: function(deletingCourse) {
            var clientIndex = $.inArray(deletingCourses, this.evaluaciones);
            this.evaluaciones.splice(clientIndex, 1);
        }
    }; 

    window.db = db;

    db.evaluaciones = [
        {
            "tareas": "Tarea de inducción (14463)",
            "ponderado_tareas": 12,
            "unidad_tarea": 1,
            "cuestionarios" : "Evaluacion del curso (12345)",
            "ponderado_cuestionario": 12,
            "unidad_cuestionario": 1,
            "foros" : "Foro tematico del curso (32165)",
            "ponderado_foros": 12,
            "unidad_foros": 1
        },
        {   
            "tareas": "Tarea de inducción (14463)",
            "ponderado_tareas": 12,
            "unidad_tarea": 1,
            "cuestionarios" : "Evaluacion del curso (12345)",
            "ponderado_cuestionario": 12,
            "unidad_cuestionario": 1,
            "foros" : "Foro tematico del curso (32165)",
            "ponderado_foros": 12,
            "unidad_foros": 1
        },
        {
            "tareas": "Tarea de inducción (14463)",
            "ponderado_tareas": 12,
            "unidad_tarea": 1,
            "cuestionarios" : "Evaluacion del curso (12345)",
            "ponderado_cuestionario": 12,
            "unidad_cuestionario": 1,
            "foros" : "Foro tematico del curso (32165)",
            "ponderado_foros": 12,
            "unidad_foros": 1
        }
        
    ];

}());