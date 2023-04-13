/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Classes/Class.java to edit this template
 */
package edu.workshopjdbc3a48.entities;

/**
 *
 * @author user
 */
public class Log {
    private int id_log;
    private int id_user;
    private String nom;
    private String type;
    private String date;

    public Log(int id_log, int id_user, String nom, String type, String date) {
        this.id_log = id_log;
        this.id_user = id_user;
        this.nom = nom;
        this.type = type;
        this.date = date;
    }

    public void setType(String type) {
        this.type = type;
    }

    public String getType() {
        return type;
    }

    public Log(int id_user, String nom, String type, String date) {
        this.id_user = id_user;
        this.nom = nom;
        this.type = type;
        this.date = date;
    }

    public Log(int id_log, int id_user, String nom, String date) {
        this.id_log = id_log;
        this.id_user = id_user;
        this.nom = nom;
        this.date = date;
    }

    public Log() {
    }

    @Override
    public String toString() {
        return "Log{" + "id_log=" + id_log + ", id_user=" + id_user + ", nom=" + nom + ", date=" + date + '}';
    }

    public void setId_log(int id_log) {
        this.id_log = id_log;
    }

    public void setId_user(int id_user) {
        this.id_user = id_user;
    }

    public void setNom(String nom) {
        this.nom = nom;
    }

    public void setDate(String date) {
        this.date = date;
    }

    public int getId_log() {
        return id_log;
    }

    public int getId_user() {
        return id_user;
    }

    public String getNom() {
        return nom;
    }

    public String getDate() {
        return date;
    }
    
}
