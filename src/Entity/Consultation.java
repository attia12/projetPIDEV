/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package Entity;

import java.sql.Time;
import java.util.Date;
import javafx.scene.control.TextField;

/**
 *
 * @author donia
 */
public class Consultation {
         private int id;
    private String  nom_patient , nom_medecin ,date,duree;

    public Consultation(int id, String nom_patient, String nom_medecin, String date, String duree) {
        this.id = id;
        this.nom_patient = nom_patient;
        this.nom_medecin = nom_medecin;
        this.date = date;
        this.duree = duree;
    }

    public Consultation(String nom_patient, String nom_medecin, String date, String duree) {
        this.nom_patient = nom_patient;
        this.nom_medecin = nom_medecin;
        this.date = date;
        this.duree = duree;
    }

    public Consultation() {
        throw new UnsupportedOperationException("Not supported yet."); //To change body of generated methods, choose Tools | Templates.
    }

    public String getDate() {
        return date;
    }

    public String getDuree() {
        return duree;
    }

    public void setDate(String date) {
        this.date = date;
    }

    public void setDuree(String duree) {
        this.duree = duree;
    }
            
    
    

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public String getNom_patient() {
        return nom_patient;
    }

    public void setNom_patient(String nom_patient) {
        this.nom_patient = nom_patient;
    }

    public String getNom_medecin() {
        return nom_medecin;
    }

    public void setNom_medecin(String nom_medecin) {
        this.nom_medecin = nom_medecin;
    }

   
    @Override
    public String toString() {
        return "Consultation{" + "id=" + id + ", nom_patient=" + nom_patient + ", nom_medecin=" + nom_medecin + ", date=" + date + ", duree=" + duree + '}';
    }
            
}
