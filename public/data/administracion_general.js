(function() {

    var db = {

        loadData: function(filter) {
            return $.grep(this.admgeneral, function(adm) {
                return (!filter.No      || adm.No.indexOf(filter.No) > -1)
                    && (!filter.id|| adm.id === filter.id)
                    && (!filter.periodo || adm.periodo.indexOf(filter.periodo) > -1)
                    &&(!filter.visible  || adm.visible.indexOf(filter.visible) > -1)
                    &&(!filter.abierto   || adm.abierto.indexOf(filter.abierto) > -1)
                    &&(!filter.patron   || adm.patron.indexOf(filter.patron) > -1)
                    &&(!filter.subsanacion || adm.subsanacion.indexOf(filter.subsanacion) > -1)
                    &&(!filter.induccion|| adm.induccion.indexOf(filter.induccion) > -1)
                    &&(!filter.presencial || adm.presencial.indexOf(filter.presencial) > -1)
                    &&(!filter.publico  || adm.publico.indexOf(filter.publico) > -1)
                    &&(!filter.fecha_de_Inicio || adm.fecha_de_Inicio.indexOf(filter.fecha_de_Inicio) > -1)
                    &&(!filter.nombre   || adm.nombre.indexOf(filter.nombre) > -1)
                    &&(!filter.secciones || adm.secciones.indexOf(filter.secciones) > -1)
                    &&(!filter.inscritos || adm.inscritos.indexOf(filter.inscritos) > -1)
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

    db.admgeneral = [{
            "No": 1,
            "id": 7839,
            "periodo":  201710,
            "visible":   true,
            "abierto":  false,
            "patron":  true,
            "subsanacion":  true,
            "induccion":  true,
            "presencial":  false,
            "publico":  0,
            "fecha_de_Inicio":  "01-02-2017",
            "nombre":  1,
            "secciones":  2,
            "inscritos":  10,
            "AP_HA":  0,
            "DE_HA":  5,  
            "RE_NP_NA":  0
        },{
            "No": 2,
            "id": 8180,
            "periodo":  201710,
            "visible":   true,
            "abierto":  true,
            "patron":  true,
            "subsanacion":  true,
            "induccion":  true,
            "presencial":  false,
            "publico":  3,
            "fecha_de_Inicio":  "12-12-2017",
            "nombre":  1,
            "secciones":  2,
            "inscritos":  10,
            "AP_HA":  0,
            "DE_HA":  5,  
            "RE_NP_NA":  0
        },{
            "No": 3,
            "id": 7909,
            "periodo":  201710,
            "visible":   false,
            "abierto":  true,
            "patron":  true,
            "subsanacion":  false,
            "induccion":  false,
            "presencial":  false,
            "publico":  5,
            "fecha_de_Inicio":  "21-08-2017",
            "nombre":  1,
            "secciones":  2,
            "inscritos":  10,
            "AP_HA":  0,
            "DE_HA":  5,  
            "RE_NP_NA":  0
        }];


    db.publico = [
        { Name: "N/E", Id: 0},
        { Name: "Ex Alumnos", Id: 1},
        { Name: "Tr. Emp. Apor.", Id: 2},
        { Name: "Alumnos SENATI", Id: 3},
        { Name: "Publico General", Id: 4},
        { Name: "Trabajadores SENATI", Id: 5},
        { Name: "Equipo SENATI VIRTUAL", Id: 6} 
    ]

    

    db.privilegios = [
        { Name: "No", Id: 0 },
        { Name: "SI", Id: 1 },
      
    ]; 

 
   

}());