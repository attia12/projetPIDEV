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
import javafx.stage.FileChooser;
import javafx.stage.Stage;

/**
 * FXML Controller class
 *
 * @author user
 */
public class AjouterUserController implements Initializable {
String s;

    public AjouterUserController() {
    }

private AfficherUserController firstInterface;
    @FXML
    private Label e_nom;
    @FXML
    private Label e_prenom;
    @FXML
    private Label e_email;
    @FXML
    private Label e_mdp;
    @FXML
    private Label e_num;

    public void setFirstInterface(AfficherUserController firstInterface) {
        this.firstInterface = firstInterface;
    }
    @FXML
    private TextField tfNom_ajout;
    @FXML
    private TextField tfPrenom_ajout;
    @FXML
    private TextField tfEmail_ajout;
    @FXML
    private TextField tfMdp_ajout;
    @FXML
    private TextField tfNum_ajout;
    @FXML
    private TextField tfaddress_ajout;
    @FXML
    private Button btnAjout;
    @FXML
    private ComboBox<String> cbType_ajout;
  
    @FXML
    private ComboBox<String> cbEtat_ajout;
    @FXML
    private Button btn_image;

    /**
     * Initializes the controller class.
     */
    @Override
    public void initialize(URL url, ResourceBundle rb) {
         ObservableList<String> items = FXCollections.observableArrayList("Admin", "Medecin", "Patient");
cbType_ajout.setItems(items); // TODO
  ObservableList<String> itemss = FXCollections.observableArrayList("0","1");
cbEtat_ajout.setItems(itemss); // TODO
    }    

    @FXML
    private void AjoutUser(ActionEvent event) throws IOException {
      System.out.println(cbType_ajout.getValue());
      System.out.println(Integer.parseInt(cbEtat_ajout.getValue()));
        Utilisateur u = new Utilisateur(tfNom_ajout.getText(),tfPrenom_ajout.getText(),tfEmail_ajout.getText(),tfMdp_ajout.getText(),tfaddress_ajout.getText(),Integer.parseInt(tfNum_ajout.getText()),cbType_ajout.getValue(),s,Integer.parseInt(cbEtat_ajout.getValue()));
      boolean check1=true,check2=true,check3=true,check5=true,check6=true;
      if (u.getNom().matches(".*\\d+.*")==true||!Character.isUpperCase(u.getNom().charAt(0)))
      {
      check1=false;
      tfNom_ajout.setStyle("-fx-background-color: #ff0000;");
      if (!Character.isUpperCase(u.getNom().charAt(0)))
      e_nom.setText("* Nom doit commence par Majuscule");
      else
      {e_nom.setText("* Nom Contenir des chiffres");}
      }
     else {
       check1=true;
      tfNom_ajout.setStyle("-fx-background-color: #ffffff;");
      e_nom.setText("");
      
      
      
      }
      if (u.getPrenom().matches(".*\\d+.*")==true||!Character.isUpperCase(u.getPrenom().charAt(0)))
      {
      check2=false;
      tfPrenom_ajout.setStyle("-fx-background-color: #ff0000;");
        if (!Character.isUpperCase(u.getPrenom().charAt(0)))
      e_prenom.setText("* Prenom doit commence par Majuscule");
      else
      {e_prenom.setText("* Prenom Contenir des chiffres");}
      
      }
       else {
       check2=true;
      tfPrenom_ajout.setStyle("-fx-background-color: #ffffff;");
      e_prenom.setText("");
      
      
      
      }
      if (!Integer.toString(u.getNum()).matches(".*\\d+.*")==true)
      {
      check3=false;
      tfNum_ajout.setStyle("-fx-background-color: #ff0000;");
      }
       else {
       check3=true;
      tfNum_ajout.setStyle("-fx-background-color: #ffffff;");
      e_num.setText("");
      
      
      
      }
      if (u.getMdp().length()<8)
      {
      check5=false;
      tfMdp_ajout.setStyle("-fx-background-color: #ff0000;");
       e_mdp.setText("* Mdp doit être > 8");
      }
       else {
       check5=true;
      tfMdp_ajout.setStyle("-fx-background-color: #ffffff;");
      e_mdp.setText("");
      
      
      
      }
      if (u.getEmail().matches("^[\\w-\\.]+@([\\w-]+\\.)+[\\w-]{2,4}$")==false)
      {
      check6=false;
      tfEmail_ajout.setStyle("-fx-background-color: #ff0000;");
       e_email.setText("* Email format incorrect");
      }
       else {
       check6=true;
      tfEmail_ajout.setStyle("-fx-background-color: #ffffff;");
      e_email.setText("");
      
      
      
      }
     if (check1&&check2&&check3&&check5&&check6)
     {ServiceUtilisateur su = new ServiceUtilisateur();
       su.ajouter(u);
    Stage stage = (Stage) btnAjout.getScene().getWindow();
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
