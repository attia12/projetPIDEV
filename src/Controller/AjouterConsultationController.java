/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package Controller;

import Entity.Consultation;
import Entity.Local;
import Services.ServiceConsultation;
import Services.ServiceLocal;
import java.io.IOException;
import java.net.URL;

import java.util.ResourceBundle;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.fxml.Initializable;
import javafx.scene.Parent;
import javafx.scene.control.Label;
import javafx.scene.control.TextField;
import javax.swing.JOptionPane;

/**
 * FXML Controller class
 *
 * @author donia
 */
public class AjouterConsultationController implements Initializable {

    @FXML
    private TextField nom_patient;
    @FXML
    private TextField nom_medecin;
    @FXML
    private TextField date;
    @FXML
    private TextField duree;
    @FXML
    private Label aa;

    /**
     * Initializes the controller class.
     */
    @Override
    public void initialize(URL url, ResourceBundle rb) {
        // TODO
    }    

    @FXML
    private void ajouter_consultation(ActionEvent event) 
            throws IOException {
        ServiceConsultation sp = new ServiceConsultation();
     
 
          String a = nom_patient.getText() ;
        String b = nom_medecin.getText() ;
        String c = date.getText() ;

        String d = duree.getText() ;
        
         if ( a.isEmpty() || b.isEmpty()  || c.isEmpty() || d.isEmpty()  ){
        JOptionPane.showMessageDialog(null, " champs obligatoire !");
        return ;
        }
         if ( !a.chars().allMatch(Character::isLetter) || 
    !b.chars().allMatch(Character::isLetter) ) {
    JOptionPane.showMessageDialog(null, "Veuillez remplir tous les champs avec des lettres uniquement!");
    return;
}

 sp.add(new Consultation(nom_patient.getText(),nom_medecin.getText(),date.getText(),duree.getText()));

        
        JOptionPane.showMessageDialog(null, "consonltation ajoutée !");
       
       FXMLLoader loader = new FXMLLoader(getClass().getResource("AfficherConsultation.fxml"));
        Parent root = loader.load();
        aa.getScene().setRoot(root);
     
        
        AfficherConsultationController dpc = loader.getController();
        
        dpc.setLbnom_patient(nom_patient.getText());
        dpc.setLbnom_medecin(nom_medecin.getText());
        dpc.setLbdate(date.getText());
        dpc.setLbduree(duree.getText());

        
        
    }

     //   sp.add(new Consultation(nom_patient.getText(),nom_medecin.getText(),Date.valueOf(date.getText()),Time.valueOf(duree.getText())));
      
     @FXML
    private void quit(ActionEvent event) throws IOException {
        FXMLLoader loader = new FXMLLoader(getClass().getResource("ChoixConsultation.fxml"));
        Parent root = loader.load();
        date.getScene().setRoot(root);
    }
    
}
