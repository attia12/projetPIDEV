/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package Services;

import Entity.Local;
import Utils.MyDB;
import java.sql.Connection;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import java.util.ArrayList;
import java.util.List;
 
/**
 *
 * @author donia
 */
public class ServiceLocal implements IService<Local>{
  Connection cnx;

    public void add(Local t) {
        try {
            String qry = "INSERT INTO `local`( `nom_block`, `nom_patient`, `nom_medecin`,`localisation`) VALUES ('" + t.getNom_block() + "','" + t.getNom_patient() + "','" + t.getNom_medecin() + "','" + t.getLocalisation()+ "')";
          cnx = MyDB.getInstance().getCnx();
            Statement stm =cnx.createStatement();   
            stm.executeUpdate(qry);
        } catch (SQLException ex) {
             System.out.println(ex.getMessage());
        }

    }
    
     
    public List<Local> afficher() {
        List<Local> locals = new ArrayList<>();
        try {
            String qry = "SELECT * FROM `local`  ";
            cnx = MyDB.getInstance().getCnx();
            Statement stm = cnx.createStatement();
            ResultSet rs = stm.executeQuery(qry);
            while (rs.next()) {
                Local p = new Local();
                p.setId(rs.getInt(1));
                p.setNom_block(rs.getString("nom_block"));
                p.setNom_patient(rs.getString("nom_patient"));
                p.setNom_medecin(rs.getString("nom_medecin"));
                p.setLocalisation(rs.getString("localisation"));
                
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
            String qry = "UPDATE `local` SET `nom_block`='" + t.getNom_block() + "', `nom_patient`='" + t.getNom_medecin() + "', `nom_patient`='" + t.getNom_medecin() + "', `localisation`='" + t.getLocalisation() + "' WHERE `nom_block`='" + t.getNom_block() + "'";

            cnx = MyDB.getInstance().getCnx();

            Statement stm = cnx.createStatement();

            stm.executeUpdate(qry);
            System.out.println("Modification avec succès!");
        } catch (SQLException ex) {
            System.out.println(ex.getMessage());
        }
    }

   public void supprimer(String t) {
                 try {
        String qry ="DELETE FROM local WHERE nom_block= '"+t+"'";
      cnx = MyDB.getInstance().getCnx();
      
            Statement stm =cnx.createStatement();
            
            stm.executeUpdate(qry);
             System.out.println("suppression avec succès!");
        } catch (SQLException ex) {
             System.out.println(ex.getMessage());
        }
        
         }

    public boolean existeDeja(String type) {
        throw new UnsupportedOperationException("Not supported yet."); //To change body of generated methods, choose Tools | Templates.
    }

    @Override
    public void supprimer(Local t) {
        throw new UnsupportedOperationException("Not supported yet."); //To change body of generated methods, choose Tools | Templates.
    }
@Override
    public Local rechercher(String p) {
       Local b=null ;
    
        String req = "SELECT * FROM local WHERE `nom_block` ='"+ p+"' ;";
        try {
            Statement st = cnx.createStatement();
            ResultSet result = st.executeQuery(req);
            while(result.next()) {
                b=(new Local(result.getString("nom_block"), result.getString("nom_patient"), result.getString("nom_medecin"), result.getString("localisation")));
               
            }
            System.out.println("local récupérées !");
        } catch (SQLException ex) {
            System.out.println(ex.getMessage());
        }
        
        return b;
    
    }
  
   
}
