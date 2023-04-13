/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/javafx/FXMLController.java to edit this template
 */
package edu.workshopjdbc3a48.gui;

import edu.workshopjdbc3a48.entities.Utilisateur;
import edu.workshopjdbc3a48.services.EmailSender;
import edu.workshopjdbc3a48.services.ServiceUtilisateur;
import java.io.IOException;
import java.net.URL;
import java.util.ResourceBundle;
import java.util.logging.Level;
import java.util.logging.Logger;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.fxml.Initializable;
import javafx.scene.Parent;
import javafx.scene.Scene;
import javafx.scene.control.Button;
import javafx.scene.control.TextField;
import javafx.stage.Stage;
import javax.mail.MessagingException;

/**
 * FXML Controller class
 *
 * @author user
 */
public class Mdp_oublieController implements Initializable {

    public Mdp_oublieController() {
    }

    @FXML
    private TextField tf_email_mdp;
    @FXML
    private Button btn_v;

    /**
     * Initializes the controller class.
     */
    @Override
    public void initialize(URL url, ResourceBundle rb) {
        // TODO
    }    

    @FXML
    private void SendEmail(ActionEvent event) {
        try {
            ServiceUtilisateur su = new ServiceUtilisateur();
            Utilisateur user = new Utilisateur();
            user=su.mdp_oublie(tf_email_mdp.getText());
    EmailSender.sendEmail(user.getEmail(), "Récuperation de mot de pass", "Bonjour "+user.getNom() + " " + user.getPrenom()+ " Suite a votre demande de recuperation de mot de pass, Votre mot de pass est : "+user.getMdp());
    System.out.println("Email sent successfully!");
} catch (MessagingException ex) {
    System.out.println("Failed to send email: " + ex.getMessage());
}
         FXMLLoader loader = new FXMLLoader(getClass().getResource("Login.fxml"));
            Parent root = null;
            try {
                root = loader.load();
            } catch (IOException ex) {
                Logger.getLogger(AfficherUserController.class.getName()).log(Level.SEVERE, null, ex);
            }
      
          
            Scene scene = new Scene(root);
            Stage stage = new Stage();
            stage.setScene(scene);
            stage.show();
     Stage stage1 = (Stage) btn_v.getScene().getWindow(); 
         stage1.close();
        
        
        
    }
    
}
