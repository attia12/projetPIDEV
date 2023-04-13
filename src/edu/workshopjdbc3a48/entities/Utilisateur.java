/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Classes/Class.java to edit this template
 */
package edu.workshopjdbc3a48.entities;

/**
 *
 * @author user
 */
public class Utilisateur {
    private int id;
    private String nom;
    private String prenom;
    private String email;
    private String mdp;
    private String Adresse;
    private int num;
    private String type;
    private String img;
    private int etat;
    private String face;
private int code;
    @Override
    public String toString() {
        return "Utilisateur{" + "id=" + id + ", nom=" + nom + ", prenom=" + prenom + ", email=" + email + ", mdp=" + mdp + ", Adresse=" + Adresse + ", num=" + num + ", type=" + type + ", img=" + img + ", etat=" + etat + '}';
    }

    public Utilisateur() {
    }

    public String getFace() {
        return face;
    }

    public Utilisateur(int id, String nom, String prenom, String email, String mdp, String Adresse, int num, String type, String img, int etat, String face) {
        this.id = id;
        this.nom = nom;
        this.prenom = prenom;
        this.email = email;
        this.mdp = mdp;
        this.Adresse = Adresse;
        this.num = num;
        this.type = type;
        this.img = img;
        this.etat = etat;
        this.face = face;
    }

    public Utilisateur(int id, String nom, String prenom, String email, String mdp, String Adresse, int num, String type, String img, int etat, String face, int code) {
        this.id = id;
        this.nom = nom;
        this.prenom = prenom;
        this.email = email;
        this.mdp = mdp;
        this.Adresse = Adresse;
        this.num = num;
        this.type = type;
        this.img = img;
        this.etat = etat;
        this.face = face;
        this.code = code;
    }

    public void setFace(String face) {
        this.face = face;
    }

    public Utilisateur(String nom, String prenom, String email, String mdp, String Adresse, int num, String type, String img, int etat) {
        this.nom = nom;
        this.prenom = prenom;
        this.email = email;
        this.mdp = mdp;
        this.Adresse = Adresse;
        this.num = num;
        this.type = type;
        this.img = img;
        this.etat = etat;
    }

    public Utilisateur(String nom, String prenom, String email, String mdp, String Adresse, int num, String type, String img, int etat, String face) {
        this.nom = nom;
        this.prenom = prenom;
        this.email = email;
        this.mdp = mdp;
        this.Adresse = Adresse;
        this.num = num;
        this.type = type;
        this.img = img;
        this.etat = etat;
        this.face = face;
    }

    public Utilisateur(int id, String nom, String prenom, String email, String mdp, String Adresse, int num, String type, String img, int etat) {
        this.id = id;
        this.nom = nom;
        this.prenom = prenom;
        this.email = email;
        this.mdp = mdp;
        this.Adresse = Adresse;
        this.num = num;
        this.type = type;
        this.img = img;
        this.etat = etat;
    }

    public void setCode(int code) {
        this.code = code;
    }

    public int getCode() {
        return code;
    }

    public void setId(int id) {
        this.id = id;
    }

    public void setNom(String nom) {
        this.nom = nom;
    }

    public void setPrenom(String prenom) {
        this.prenom = prenom;
    }

    public void setEmail(String email) {
        this.email = email;
    }

    public void setMdp(String mdp) {
        this.mdp = mdp;
    }

    public void setAdresse(String Adresse) {
        this.Adresse = Adresse;
    }

    public void setNum(int num) {
        this.num = num;
    }

    public void setType(String type) {
        this.type = type;
    }

    public void setImg(String img) {
        this.img = img;
    }

    public void setEtat(int etat) {
        this.etat = etat;
    }

    public int getId() {
        return id;
    }

    public String getNom() {
        return nom;
    }

    public String getPrenom() {
        return prenom;
    }

    public String getEmail() {
        return email;
    }

    public String getMdp() {
        return mdp;
    }

    public String getAdresse() {
        return Adresse;
    }

    public int getNum() {
        return num;
    }

    public String getType() {
        return type;
    }

    public String getImg() {
        return img;
    }

    public int getEtat() {
        return etat;
    }
    
}
