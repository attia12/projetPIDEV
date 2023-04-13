/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/javafx/FXMLController.java to edit this template
 */
package edu.workshopjdbc3a48.gui;

import edu.workshopjdbc3a48.entities.Utilisateur;
import edu.workshopjdbc3a48.services.ServiceUtilisateur;
import java.io.File;
import java.io.IOException;
import java.net.URL;
import java.util.ResourceBundle;
import java.util.logging.Level;
import java.util.logging.Logger;
import javafx.collections.FXCollections;
import javafx.collections.ObservableList;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.fxml.Initializable;
import javafx.scene.Node;
import javafx.scene.Parent;
import javafx.scene.Scene;
import javafx.scene.control.Button;
import javafx.scene.control.ComboBox;
import javafx.scene.control.Label;
import javafx.scene.control.TextField;
import javafx.scene.control.cell.PropertyValueFactory;
import javafx.stage.FileChooser;
import javafx.stage.Stage;

/**
 * FXML Controller class
 *
 * @author user
 */
public class ModifierUserController implements Initializable {
String s;
private Utilisateur us;
private AfficherUserController firstInterface;

    public ModifierUserController() {
    }
   
    @FXML
    private Label e_nom_mod;
    @FXML
    private Label e_prenom_mod;
    @FXML
    private Label e_email_mod;
    @FXML
    private Label e_mdp_mod;
    @FXML
    private Label e_num_mod;

    public void setFirstInterface(AfficherUserController firstInterface) {
        this.firstInterface = firstInterface;
    }
    public Utilisateur getUs() {
        return us;
    }

    public void setUs(Utilisateur us) {
        this.us = us;
        tfNom_mod.setText(us.getNom());
        tfPrenom_mod.setText(us.getPrenom());
        tfEmail_mod.setText(us.getEmail());
        tfMdp_mod.setText(us.getMdp());
        tfNum_mod.setText(Integer.toString(us.getNum()));
        tfaddress_mod.setText(us.getAdresse());
        cbType_mod.setValue(us.getType());
         cbEtat_mod.setValue(Integer.toString(us.getEtat()));
       
    }
    
    @FXML
    private TextField tfNom_mod;
    @FXML
    private TextField tfPrenom_mod;
    @FXML
    private TextField tfEmail_mod;
    @FXML
    private TextField tfMdp_mod;
    @FXML
    private TextField tfNum_mod;
    @FXML
    private TextField tfaddress_mod;
    @FXML
    private Button btnMod;
    @FXML
    private ComboBox<String> cbType_mod;
    @FXML
    private ComboBox<String> cbEtat_mod;
    @FXML
    private Button btn_image_mod;

    /**
     * Initializes the controller class.
     */
    @Override
    public void initialize(URL url, ResourceBundle rb) {
        
        ObservableList<String> items = FXCollections.observableArrayList("Admin", "Medecin", "Patient");
cbType_mod.setItems(items); // TODO
  ObservableList<String> itemss = FXCollections.observableArrayList("0","1");
cbEtat_mod.setItems(itemss); // TODO // TODO
//
//



    }    

    @FXML
    private void ModUser(ActionEvent event) throws IOException {
          
        Utilisateur u = new Utilisateur(us.getId(),tfNom_mod.getText(),tfPrenom_mod.getText(),tfEmail_mod.getText(),tfMdp_mod.getText(),tfaddress_mod.getText(),Integer.parseInt(tfNum_mod.getText()),cbType_mod.getValue(),s,Integer.parseInt(cbEtat_mod.getValue()));
      
       // System.out.print(u);
       
       // Utilisateur u=new Utilisateur("Test","Mohamed","Mohamedtrabelsiph@gmail.com","1234","bfdberg",2654684,"gevedgrv","vfdbeber",6545864);
        boolean check1=true,check2=true,check3=true,check5=true,check6=true;
      if (u.getNom().matches(".*\\d+.*")==true||!Character.isUpperCase(u.getNom().charAt(0)))
      {
      check1=false;
      tfNom_mod.setStyle("-fx-background-color: #ff0000;");
      if (!Character.isUpperCase(u.getNom().charAt(0)))
      e_nom_mod.setText("* Nom doit commence par Majuscule");
      else
      {e_nom_mod.setText("* Nom Contenir des chiffres");}
      }
     else {
       check1=true;
      tfNom_mod.setStyle("-fx-background-color: #ffffff;");
      e_nom_mod.setText("");
      
      
      
      }
      if (u.getPrenom().matches(".*\\d+.*")==true||!Character.isUpperCase(u.getPrenom().charAt(0)))
      {
      check2=false;
      tfPrenom_mod.setStyle("-fx-background-color: #ff0000;");
        if (!Character.isUpperCase(u.getPrenom().charAt(0)))
      e_prenom_mod.setText("* Prenom doit commence par Majuscule");
      else
      {e_prenom_mod.setText("* Prenom Contenir des chiffres");}
      
      }
       else {
       check2=true;
      tfPrenom_mod.setStyle("-fx-background-color: #ffffff;");
      e_prenom_mod.setText("");
      
      
      
      }
      if (!Integer.toString(u.getNum()).matches(".*\\d+.*")==true)
      {
      check3=false;
      tfNum_mod.setStyle("-fx-background-color: #ff0000;");
      }
       else {
       check3=true;
      tfNum_mod.setStyle("-fx-background-color: #ffffff;");
      e_num_mod.setText("");
      
      
      
      }
      if (u.getMdp().length()<8)
      {
      check5=false;
      tfMdp_mod.setStyle("-fx-background-color: #ff0000;");
       e_mdp_mod.setText("* Mdp doit être > 8");
      }
       else {
       check5=true;
      tfMdp_mod.setStyle("-fx-background-color: #ffffff;");
      e_mdp_mod.setText("");
      
      
      
      }
      if (u.getEmail().matches("^[\\w-\\.]+@([\\w-]+\\.)+[\\w-]{2,4}$")==false)
      {
      check6=false;
      tfEmail_mod.setStyle("-fx-background-color: #ff0000;");
       e_email_mod.setText("* Email format incorrect");
      }
       else {
       check6=true;
      tfEmail_mod.setStyle("-fx-background-color: #ffffff;");
      e_email_mod.setText("");
      
      
      
      }
       
      
       if (check1&&check2&&check3&&check5&&check6){
      ServiceUtilisateur su = new ServiceUtilisateur();
       su.modifier(u);


    
    Stage stage = (Stage) btnMod.getScene().getWindow();
    stage.close();   
 
 firstInterface.update();}
    }

    @FXML
    private void AddImage(ActionEvent event) {
         FileChooser fileChooser = new FileChooser();
File selectedFile = fileChooser.showOpenDialog(null);
        
        s=selectedFile.toString();
        System.out.println(s);
    }
    
}
