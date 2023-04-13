/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package Services;

import Entity.Consultation;
import Entity.Local;
import Utils.MyDB;
import java.sql.Connection;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import java.sql.Time;
import java.util.ArrayList;
import java.util.Date;
import java.util.List;

/**
 *
 * @author donia
 */
public class ServiceConsultation implements IService<Consultation>{
  Connection cnx;
   

 @Override
    public void add(Consultation t) {
        try {
            String qry = "INSERT INTO `consultation`( `nom_patient`, `nom_medecin`, `date`,`duree`) VALUES ('" + t.getNom_patient() + "','" + t.getNom_medecin() + "','" + t.getDate() + "','" + t.getDuree()+ "')";
          cnx = MyDB.getInstance().getCnx();
            Statement stm =cnx.createStatement();   
            stm.executeUpdate(qry);
        } catch (SQLException ex) {
             System.out.println(ex.getMessage());
        }

    }
    
      @Override
    public List<Consultation> afficher() {
        List<Consultation> consultations = new ArrayList<>();
        try {
            String qry = "SELECT * FROM `consultation`  ";
            cnx = MyDB.getInstance().getCnx();
            Statement stm = cnx.createStatement();
            ResultSet rs = stm.executeQuery(qry);
            while (rs.next()) {
              Consultation p = new Consultation();
                p.setId(rs.getInt(1));
                p.setNom_patient(rs.getString("nom_patient"));
                p.setNom_patient(rs.getString("nom_medecin"));
                p.setNom_medecin(rs.getString("date"));
                p.setDuree(rs.getString("duree"));
                
                
                consultations.add(p);
            }
            return consultations;

        } catch (SQLException ex) {
            System.out.println(ex.getMessage());
        }
        return consultations;

    }
   

   
 @Override
    public void modifier(Consultation t) {
        try {
            String qry = "UPDATE `consultation` SET `nom_patient`='" + t.getNom_patient() + "', `nom_medecin`='" + t.getNom_medecin() + "', `date`='" + t.getDate() + "', `duree`='" + t.getDuree() + "' WHERE `id`='" + t.getId() + "'";

            cnx = MyDB.getInstance().getCnx();

            Statement stm = cnx.createStatement();

            stm.executeUpdate(qry);
            System.out.println("Modification avec succès!");
        } catch (SQLException ex) {
            System.out.println(ex.getMessage());
        }
    }


    @Override
    public void supprimer(Consultation t) {
 try {
        String qry ="DELETE FROM consultation WHERE nom_patient = '" + t.getNom_patient()+ "'";
      cnx = MyDB.getInstance().getCnx();
      
            Statement stm =cnx.createStatement();
            
            stm.executeUpdate(qry);
            
        } catch (SQLException ex) {
             System.out.println(ex.getMessage());
        }    }

    @Override
    public Local rechercher(String p) {
        throw new UnsupportedOperationException("Not supported yet."); //To change body of generated methods, choose Tools | Templates.
    }

   

  
   
}
