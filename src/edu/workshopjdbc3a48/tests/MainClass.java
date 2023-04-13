/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package edu.workshopjdbc3a48.tests;


import edu.workshopjdbc3a48.entities.Utilisateur;
import edu.workshopjdbc3a48.gui.AffichageUser;
import edu.workshopjdbc3a48.gui.Login;
import edu.workshopjdbc3a48.services.ServiceUtilisateur;
import edu.workshopjdbc3a48.services.UserSession;
import java.io.BufferedReader;
import java.io.FileReader;
import java.io.IOException;


import javafx.application.Application;


/**
 *
 * @author abdelazizmezri
 */
public class MainClass {
    
    public static void main(String[] args) {
        
     /*  Utilisateur u1=new Utilisateur("Test","Mohamed","Mohamedtrabelsiph@gmail.com","1234","bfdberg",2654684,"gevedgrv","vfdbeber",6545864);
        int i=0;
        ServiceUtilisateur sp = new ServiceUtilisateur();
        //sp.ajouter(u1);
        List l=sp.getAll();
        while (i<l.size())
        { System.out.println(l.get(i));
        i++;}
        sp.supprimer(73);
        /*sp.ajouter(p1);
        sp.ajouter(p2);
        sp.ajouter2(p3);
        sp.ajouter2(p4);*/
        
        //sp.supprimer(3);*/
 
        // Application.launch(Login.class, args);
             String fileName = "data.txt";
  String line = "";
            String data = "";
        try {
            BufferedReader reader = new BufferedReader(new FileReader(fileName));
          
            while ((line = reader.readLine()) != null) {
                data += line ;
            }
            reader.close();
          // int d=Integer.parseInt(data);
            System.out.println("Data read from file: " + data);
        } catch (IOException e) {
            System.out.println("Error reading from file.");
            e.printStackTrace();
        }
        if ("".equals(data))
       Application.launch(Login.class, args);
        else
        {
            Utilisateur user=new Utilisateur();
            ServiceUtilisateur su=new ServiceUtilisateur();
            user=su.RechercheByID(Integer.parseInt(data));
            UserSession.getInstance().setCurrentUser(user);
            Application.launch(AffichageUser.class, args);
        }
    
    }
    
}
