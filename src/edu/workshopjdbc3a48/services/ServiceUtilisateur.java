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
import java.time.LocalDate;
import java.util.ArrayList;
import java.util.List;

/**
 *
 * @author user
 */
public class ServiceUtilisateur  implements IService<Utilisateur> {
      Connection cnx = DataSource.getInstance().getCnx();

  
      @Override
    public void ajouter(Utilisateur u) {
        try {
            String req = "INSERT INTO `Utilisateur` (`nom`, `prenom`, `email`, `mdp`, `adresse`, `num`, `type`, `img`, `etat`) VALUES (?,?,?,?,?,?,?,?,?)";
            PreparedStatement ps = cnx.prepareStatement(req);
            ps.setString(2, u.getPrenom());
            ps.setString(1, u.getNom());
            ps.setString(3, u.getEmail());
            ps.setString(4, u.getMdp());
            ps.setString(5, u.getAdresse());
            ps.setString(6, Integer.toString(u.getNum()));
            ps.setString(7, u.getType());
            ps.setString(8, u.getImg());
            ps.setString(9, Integer.toString(u.getEtat()));
            ps.executeUpdate();
        } catch (SQLException ex) {
            System.out.println(ex.getMessage());
        }
        ServiceLog sl = new ServiceLog();
        Utilisateur us = UserSession.getInstance().getCurrentUser();
        LocalDate currentDate = LocalDate.now();
        System.out.print(currentDate);
        Log l=new Log(us.getId(),u.getNom()+" "+u.getPrenom(),"Ajout",currentDate.toString());
        sl.ajouter(l);
    }

    @Override
    public void supprimer(int id) {
        Utilisateur u = RechercheByID(id);
        try {
            String req = "DELETE FROM `Utilisateur` WHERE id = " + id;
            Statement st = cnx.createStatement();
            st.executeUpdate(req);
            System.out.println("Personne deleted !");
        } catch (SQLException ex) {
            System.out.println(ex.getMessage());
        }
         ServiceLog sl = new ServiceLog();
        Utilisateur us = UserSession.getInstance().getCurrentUser();
        LocalDate currentDate = LocalDate.now();
        System.out.print(currentDate);
        
        Log l=new Log(us.getId(),u.getNom()+" "+u.getPrenom(),"Suppression",currentDate.toString());
        sl.ajouter(l);
    }

    public void modifier(Utilisateur u) {
        try {
            String req = "UPDATE `Utilisateur` SET `nom` = '" + u.getNom() + "', `prenom` = '" + u.getPrenom()+ "', `email` = '" + u.getEmail()+ "', `mdp` = '" + u.getMdp()+ "', `adresse` = '" + u.getAdresse()+ "', `num` = " + u.getNum()+ ", `type` = '" + u.getType() + "', `etat` = " + u.getEtat()+ ", `img` = '" + u.getImg()+ "' WHERE id = " + u.getId();
            Statement st = cnx.createStatement();
            st.executeUpdate(req);
            System.out.println("User updated !");
        } catch (SQLException ex) {
            System.out.println(ex.getMessage());
        }
         ServiceLog sl = new ServiceLog();
        Utilisateur us = UserSession.getInstance().getCurrentUser();
        LocalDate currentDate = LocalDate.now();
        System.out.print(currentDate);
        
        Log l=new Log(us.getId(),u.getNom()+" "+u.getPrenom(),"Modification",currentDate.toString());
        sl.ajouter(l);
    }

    @Override
    public List<Utilisateur> getAll() {
        List<Utilisateur> list = new ArrayList<>();
        try {
            String req = "Select * from utilisateur";
            Statement st = cnx.createStatement();
            ResultSet rs = st.executeQuery(req);
           
            while(rs.next()){
                Utilisateur u = new Utilisateur(rs.getInt(1), rs.getString("nom"), rs.getString("prenom"), rs.getString(4), rs.getString(5), rs.getString(6), rs.getInt(7), rs.getString(8) ,rs.getString(9), rs.getInt(10),rs.getString(11));
                
                list.add(u);
            }
        } catch (SQLException ex) {
            System.out.println(ex.getMessage());
        }

        return list;
        
    }
public Utilisateur RechercheByID(int id)
{ Utilisateur user= new Utilisateur();
        try {
            String req = "Select * from utilisateur where id = "+id;
            Statement st = cnx.createStatement();
            ResultSet rs = st.executeQuery(req);
           
            while(rs.next()){
                Utilisateur u = new Utilisateur(rs.getInt(1), rs.getString("nom"), rs.getString("prenom"), rs.getString(4), rs.getString(5), rs.getString(6), rs.getInt(7), rs.getString(8) ,rs.getString(9), rs.getInt(10));
                user=u;
                
            }
        } catch (SQLException ex) {
            System.out.println(ex.getMessage());
        }

      return user;



}
public Utilisateur Login(String Email,String Mdp){
Utilisateur user= new Utilisateur();
        try {
            String req = "Select * from utilisateur where Email = '"+Email+"' and Mdp='"+Mdp+"'";
            Statement st = cnx.createStatement();
            ResultSet rs = st.executeQuery(req);
           
            while(rs.next()){
 Utilisateur u;
                u = new Utilisateur(rs.getInt(1), rs.getString("nom"), rs.getString("prenom"), rs.getString(4), rs.getString(5), rs.getString(6), rs.getInt(7), rs.getString(8) ,rs.getString(9), rs.getInt(10));
                user=u;
                
            }
        } catch (SQLException ex) {
            System.out.println(ex.getMessage());
        }

      return user;



}
public boolean checkLogin(String Email,String Mdp) throws SQLException{

      
            String req = "Select * from utilisateur where Email = '"+Email+"' and Mdp='"+Mdp+"'  " ;
            Statement st = cnx.createStatement();
            ResultSet rs = st.executeQuery(req);
           
          return rs.next();
    



}
public Utilisateur mdp_oublie(String email){
Utilisateur user= new Utilisateur();
        try {
            String req = "Select * from utilisateur where Email = '"+email+"'";
            Statement st = cnx.createStatement();
            ResultSet rs = st.executeQuery(req);
           
            while(rs.next()){
 Utilisateur u;
                u = new Utilisateur(rs.getInt(1), rs.getString("nom"), rs.getString("prenom"), rs.getString(4), rs.getString(5), rs.getString(6), rs.getInt(7), rs.getString(8) ,rs.getString(9), rs.getInt(10));
                user=u;
                
            }
        } catch (SQLException ex) {
            System.out.println(ex.getMessage());
        }

      return user;



}
   public void ActiverUser(Utilisateur u)
   {
   try {
            String req = "UPDATE `Utilisateur` SET `etat` = 1 WHERE email = '" + u.getEmail()+"'";
            Statement st = cnx.createStatement();
            st.executeUpdate(req);
            System.out.println("User updated !");
        } catch (SQLException ex) {
            System.out.println(ex.getMessage());
        }
   
   
   
   }
   
   public boolean BloquerUser(Utilisateur u){
   int check=0;
    try {
            String req = "UPDATE `Utilisateur` SET `etat` = 0 WHERE id = " + u.getId();
            Statement st = cnx.createStatement();
            check=st.executeUpdate(req);
       
           
        } catch (SQLException ex) {
            System.out.println(ex.getMessage());
        } 
   
   return check==1;
   
   }
   public void ajouter_Front(Utilisateur u) {
        try {
            String req = "INSERT INTO `Utilisateur` (`nom`, `prenom`, `email`, `mdp`, `adresse`, `num`, `type`, `img`, `etat`,`face_id`) VALUES (?,?,?,?,?,?,?,?,?,?)";
            PreparedStatement ps = cnx.prepareStatement(req);
            ps.setString(2, u.getPrenom());
            ps.setString(1, u.getNom());
            ps.setString(3, u.getEmail());
            ps.setString(4, u.getMdp());
            ps.setString(5, u.getAdresse());
            ps.setString(6, Integer.toString(u.getNum()));
            ps.setString(7, u.getType());
            ps.setString(8, u.getImg());
            ps.setString(9, Integer.toString(u.getEtat()));
              ps.setString(10, u.getFace());
            ps.executeUpdate();
        } catch (SQLException ex) {
            System.out.println(ex.getMessage());
        }
    }
}
