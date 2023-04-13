/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Classes/Class.java to edit this template
 */
package edu.workshopjdbc3a48.services;

import edu.workshopjdbc3a48.entities.Log;
import edu.workshopjdbc3a48.entities.Personne;
import edu.workshopjdbc3a48.entities.Utilisateur;
import edu.workshopjdbc3a48.utils.DataSource;
import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import java.util.ArrayList;
import java.util.List;

/**
 *
 * @author user
 */
public class ServiceLog implements IService<Log>{
     Connection cnx = DataSource.getInstance().getCnx();

    @Override
    public void ajouter(Log l) {
        try {
            String req = "INSERT INTO `Logs` (`id_user`,`nom_user_modifie`, `type`,`date`) VALUES (" + l.getId_user() + ", '" + l.getNom() + "', '"+l.getType()+"', '"+l.getDate()+"')";
            Statement st = cnx.createStatement();
            st.executeUpdate(req);
            System.out.println("Personne created !");
        } catch (SQLException ex) {
            System.out.println(ex.getMessage());
        }
    }
    
    public void ajouter2(Personne p) {
        try {
            String req = "INSERT INTO `personne` (`nom`, `prenom`) VALUES (?,?)";
            PreparedStatement ps = cnx.prepareStatement(req);
            ps.setString(2, p.getPrenom());
            ps.setString(1, p.getNom());
            ps.executeUpdate();
        } catch (SQLException ex) {
            System.out.println(ex.getMessage());
        }
    }

    
     @Override
    public void supprimer(int id) {
        try {
            String req = "DELETE FROM `Logs` where id_log ="+id;
            Statement st = cnx.createStatement();
            st.executeUpdate(req);
            System.out.println("Personne deleted !");
        } catch (SQLException ex) {
            System.out.println(ex.getMessage());
        }
    }

    @Override
    public void modifier(Log l) {
        try {
            String req = "UPDATE `Logs` SET `nom_user_modifie` = '" + l.getNom() +  "', `date` = '" + l.getDate() +"' WHERE `Logs`.`id_log` = " + l.getId_log();
            Statement st = cnx.createStatement();
            st.executeUpdate(req);
            System.out.println("Personne updated !");
        } catch (SQLException ex) {
            System.out.println(ex.getMessage());
        }
    }

    @Override
    public List<Log> getAll() {
        List<Log> list = new ArrayList<>();
        try {
             Utilisateur u = UserSession.getInstance().getCurrentUser();
            String req = "Select * from Logs where id_user="+u.getId();
            Statement st = cnx.createStatement();
            ResultSet rs = st.executeQuery(req);
            while(rs.next()){
               Log p = new Log(rs.getInt(1), u.getId(), rs.getString(3),rs.getString(4),rs.getString(5));
                list.add(p);
            }
        } catch (SQLException ex) {
            System.out.println(ex.getMessage());
        }

        return list;
    }

}
