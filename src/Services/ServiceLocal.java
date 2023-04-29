/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package Services;


import Connection.MyDB;
import Entity.Local;
import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import java.util.ArrayList;
import java.util.List;
import java.util.logging.Level;
import java.util.logging.Logger;
import javafx.collections.FXCollections;
import javafx.collections.ObservableList;

/**
 *
 * @author donia
 */
public class ServiceLocal implements IService<Local>{
 Connection cnx;



    public void add(Local t) {
        try {
            String qry = "INSERT INTO `local`(`nom_block`, `nom_patient`,`nom_medecin`,`localisation`,`Image`) VALUES ('" + t.getNom_block() + "','" + t.getNom_patient() + "','" + t.getNom_medecin() + "','" + t.getLocalisation()+ "','"+t.getImage() + "')";
          cnx = MyDB.getInstance().getCnx();
            Statement stm =cnx.createStatement();   
            stm.executeUpdate(qry);
        } catch (SQLException ex) {
             System.out.println(ex.getMessage());
        }
    }
    
    
     public ObservableList<Local> afficherData() {
        ObservableList<Local> classifications = FXCollections.observableArrayList();
        try {
            PreparedStatement qry =cnx.prepareStatement("SELECT * FROM `local`");
            cnx = MyDB.getInstance().getCnx();
            ResultSet rs = qry.executeQuery();
            while(rs.next()){
                Local c =new Local();
                c.setId(rs.getInt(1));
                c.setNom_block(rs.getString(2));
                c.setNom_patient(rs.getString(3));
                 c.setNom_medecin(rs.getString(4));
                c.setLocalisation(rs.getString(5));
                c.setImage(rs.getString(6));
                classifications.add(c);
            }
            return classifications;
            
            
        } catch (SQLException ex) {
            System.out.println(ex.getMessage());
        }
        return classifications;
    }
   
     
    public List<Local> afficher() {
        List<Local> locals = new ArrayList<>();
        try {
                        cnx = MyDB.getInstance().getCnx();

            String qry = "SELECT * FROM `local`  ";
            Statement stm = cnx.createStatement();
            ResultSet rs = stm.executeQuery(qry);
            while (rs.next()) {
                Local p = new Local();
                p.setId(rs.getInt(1));
                p.setNom_block(rs.getString("nom_block"));
                p.setNom_patient(rs.getString("nom_patient"));
                p.setNom_medecin(rs.getString("nom_medecin"));
                p.setLocalisation(rs.getString("localisation"));
                                p.setImage(rs.getString("Image"));

                locals.add(p);
            }
            return locals;
 
        } catch (SQLException ex) {
            System.out.println(ex.getMessage());
        }
        return locals;

    }

    public void modifier(Local t) {
        try {
            String qry = "UPDATE `local` SET `nom_block`='" + t.getNom_block() + "', `nom_patient`='" + t.getNom_medecin() + "', `nom_patient`='" + t.getNom_medecin() + "', `localisation`='" + t.getLocalisation() + "', `Image`='" + t.getImage() + "' WHERE `nom_block`='" + t.getNom_block() + "'";

            cnx = MyDB.getInstance().getCnx();

            Statement stm = cnx.createStatement();

            stm.executeUpdate(qry);
            System.out.println("Modification avec succès!");
        } catch (SQLException ex) {
            System.out.println(ex.getMessage());
        }
    }

   public void supprimer(Local t) {
                 try {
        String qry ="DELETE FROM local WHERE nom_block= '"+t.getNom_block()+"'";
      cnx = MyDB.getInstance().getCnx();
      
            Statement stm =cnx.createStatement();
            
            stm.executeUpdate(qry);
             System.out.println("suppression avec succès!");
        } catch (SQLException ex) {
             System.out.println(ex.getMessage());
        }
        
         }

  
   

   
    }
      

