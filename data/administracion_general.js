(function() {

    var db = {

        loadData: function(filter) {
            return $.grep(this.admgeneral, function(adm) {
                return (!filter.No      || adm.No.indexOf(filter.No) > -1)
                    && (!filter.Id_Curso|| adm.Id_Curso === filter.Id_Curso)
                    && (!filter.Periodo || adm.Periodo.indexOf(filter.Periodo) > -1)
                    &&(!filter.Visible  || adm.Visible.indexOf(filter.Visible) > -1)
                    &&(!filter.Abierto   || adm.Abierto.indexOf(filter.Abierto) > -1)
                    &&(!filter.Patron   || adm.Patron.indexOf(filter.Patron) > -1)
                    &&(!filter.Subsanacion || adm.Subsanacion.indexOf(filter.Subsanacion) > -1)
                    &&(!filter.Induccion|| adm.Induccion.indexOf(filter.Induccion) > -1)
                    &&(!filter.Presencial || adm.Presencial.indexOf(filter.Presencial) > -1)
                    &&(!filter.Publico  || adm.Publico.indexOf(filter.Publico) > -1)
                    &&(!filter.Fecha_de_Inicio || adm.Fecha_de_Inicio.indexOf(filter.Fecha_de_Inicio) > -1)
                    &&(!filter.Nombre   || adm.Nombre.indexOf(filter.Nombre) > -1)
                    &&(!filter.Secciones || adm.Secciones.indexOf(filter.Secciones) > -1)
                    &&(!filter.Inscritos || adm.Inscritos.indexOf(filter.Inscritos) > -1)
                    &&(!filter.AP_HA    || adm.AP_HA.indexOf(filter.AP_HA) > -1)
                    &&(!filter.DE_HA    || adm.DE_HA.indexOf(filter.DE_HA) > -1)
                    &&(!filter.RE_NP_NA || adm.RE_NP_NA.indexOf(filter.RE_NP_NA) > -1)
                                  
            });
        },
        insertItem: function(insertingAdm) {
            this.admgeneral.push(insertingAdm);
        },
        updateItem: function(updatingAdm) { },

        deleteItem: function(deletingAdm) {
            var clientIndex = $.inArray(deletingAdmgeneral, this.admgeneral);
            this.admgeneral.splice(clientIndex, 1);
        }
    }; 

    window.db = db;

    db.admgeneral = [
        {
            "No": 1,
            "Id_Curso": 7899 ,
            "Abierto": 0,
            "Patron": 0,
            "Subsanacion": 0,
            "Induccion": 0,
            "Presencial": 0,
            "Publico": 0,
            "Fecha_de_Inicio": "25-03-2017",
            "Secciones": 1,
            "Inscritos": 48,
            "AP_HA": 0,
            "DE_HA": 0,
            "RE_NP_NA": 5,  
			"Visible": 0
        }      
    ];




    db.privilegios = [
        { Name: "No", Id: 0 },
        { Name: "SI", Id: 1 },
      
    ]; 

 
   

}());