/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package Entity;

import java.time.LocalDate;

/**
 *
 * @author donia
 */
public class Local {
      private int id;
    private String nom_block , nom_patient , nom_medecin ,localisation , image;

    public Local(int id, String nom_block, String nom_patient, String nom_medecin, String localisation , String image) {
        this.id = id;
        this.nom_block = nom_block;
        this.nom_patient = nom_patient;
        this.nom_medecin = nom_medecin;
        this.localisation = localisation;
        this.image = image ;
    }

    public Local() {
    }

    public Local(String nom_block, String nom_patient, String nom_medecin, String localisation , String image) {
        this.nom_block = nom_block;
        this.nom_patient = nom_patient;
        this.nom_medecin = nom_medecin;
        this.localisation = localisation;
        this.image = image ;
    }

    public String getImage() {
        return image;
    }

    public void setImage(String image) {
        this.image = image;
    }


    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public String getNom_block() {
        return nom_block;
    }

    public void setNom_block(String nom_block) {
        this.nom_block = nom_block;
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

    public String getLocalisation() {
        return localisation;
    }

    public void setLocalisation(String localisation) {
        this.localisation = localisation;
    }

    @Override
    public String toString() {
        return "Local{" + "id=" + id + ", nom_block=" + nom_block + ", nom_patient=" + nom_patient + ", nom_medecin=" + nom_medecin + ", localisation=" + localisation + '}';
    }


     
}
