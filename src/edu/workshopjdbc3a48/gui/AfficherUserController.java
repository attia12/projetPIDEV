/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/javafx/FXMLController.java to edit this template
 */
package edu.workshopjdbc3a48.gui;

import edu.workshopjdbc3a48.entities.Utilisateur;
import edu.workshopjdbc3a48.services.ServiceUtilisateur;
import edu.workshopjdbc3a48.services.UserSession;
import java.io.File;
import java.io.FileWriter;
import java.io.IOException;
import java.net.URL;
import java.util.ArrayList;
import java.util.List;
import java.util.Optional;
import java.util.ResourceBundle;
import java.util.logging.Level;
import java.util.logging.Logger;
import javafx.collections.FXCollections;
import javafx.collections.ObservableList;
import javafx.event.ActionEvent;
import javafx.event.EventType;
import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.fxml.Initializable;
import javafx.scene.Parent;
import javafx.scene.Scene;
import javafx.scene.control.Alert;
import javafx.scene.control.Alert.AlertType;
import javafx.scene.control.Button;
import javafx.scene.control.ButtonType;
import javafx.scene.control.Label;
import javafx.scene.control.TableCell;
import javafx.scene.control.TableColumn;
import javafx.scene.control.TableView;
import javafx.scene.control.cell.PropertyValueFactory;
import javafx.scene.image.Image;
import javafx.scene.image.ImageView;
import javafx.scene.input.MouseEvent;
import javafx.scene.layout.Pane;
import javafx.stage.Stage;
import javafx.util.Callback;

/**
 * FXML Controller class
 *
 * @author user
 */
public class AfficherUserController implements Initializable {

    @FXML
    private TableColumn<Utilisateur, String> col_bloq;
    @FXML
    private Button btn_log;
    @FXML
    private Pane pane;
    @FXML
    private ImageView pdp;
    @FXML
    private Label nom_session;
    @FXML
    private Label btn_dec;

    public AfficherUserController() {
    }

    @FXML
     TableView<Utilisateur> tab_user;
    @FXML
     TableColumn<Utilisateur, String> col_nom;
    @FXML
     TableColumn<Utilisateur, String> col_prenom;
    @FXML
     TableColumn<Utilisateur, String> col_email;
    @FXML
     TableColumn<Utilisateur, String> col_mdp;
    @FXML
     TableColumn<Utilisateur, String> col_num;
    @FXML
     TableColumn<Utilisateur, String> col_addresse;
    @FXML
     TableColumn<Utilisateur, String> col_type;
    @FXML
     TableColumn<Utilisateur, String> col_etat;
    @FXML
     TableColumn<Utilisateur, String> col_img;
    @FXML
    private Button add_btn;
    @FXML
    private TableColumn<Utilisateur, String> col_sup;
  
    /**
     * Initializes the controller class.
     */
    @Override
    public void initialize(URL url, ResourceBundle rb) {
      
      Utilisateur u = UserSession.getInstance().getCurrentUser();
        System.out.println(u);
        File file = new File(u.getImg());
if(file.exists()) {
    Image image = new Image(file.toURI().toString());
    pdp.setImage(image);
} else {
    System.out.println("Image file not found!");
}
        nom_session.setText(u.getNom()+" "+u.getPrenom());
        ServiceUtilisateur su = new ServiceUtilisateur();
        List<Utilisateur> list= new ArrayList<>();// TODO
        list=su.getAll();
       
         ObservableList<Utilisateur> observableList = FXCollections.observableArrayList(list);
    tab_user.setItems(observableList);
     col_bloq.setCellFactory(new Callback<TableColumn<Utilisateur, String>, TableCell<Utilisateur, String>>() {
    @Override
    public TableCell<Utilisateur, String> call(TableColumn<Utilisateur, String> col) {
        final TableCell<Utilisateur, String> cell = new TableCell<Utilisateur, String>() {
            final Button btnn = new Button("Bloquer");
            
              @Override
              
            public void updateItem(String item, boolean empty) {
              
                {
                    setGraphic(btnn);
                }
            }
            {
                btnn.setOnAction((ActionEvent event) -> {
                    Utilisateur user = getTableView().getItems().get(getIndex());
                    ServiceUtilisateur su = new ServiceUtilisateur();
                   boolean check= su.BloquerUser(user);
                   if (check)
             {
               Alert alert = new Alert(Alert.AlertType.INFORMATION);
alert.setTitle("Alerte");
alert.setHeaderText(null);
alert.setContentText("Utilisateur bloquée !");
alert.showAndWait();
             
             }
                    update();
                });
            }
          
        };
        return cell;
    }
});
    col_sup.setCellFactory(new Callback<TableColumn<Utilisateur, String>, TableCell<Utilisateur, String>>() {
    @Override
    public TableCell<Utilisateur, String> call(TableColumn<Utilisateur, String> col) {
        final TableCell<Utilisateur, String> cell = new TableCell<Utilisateur, String>() {
            final Button btn = new Button("Supprimer");
            
              @Override
              
            public void updateItem(String item, boolean empty) {
              
                {
                    setGraphic(btn);
                }
            }
            {
               btn.setOnAction((ActionEvent event) -> {
    Utilisateur user = getTableView().getItems().get(getIndex());

    Alert alert = new Alert(AlertType.CONFIRMATION);
    alert.setTitle("Confirmation de suppression");
    alert.setHeaderText("Supprimer l'utilisateur " + user.getNom() +" "+user.getPrenom()+ " ?");
    alert.setContentText("Êtes-vous sûr de vouloir supprimer cet utilisateur ?");

    Optional<ButtonType> result = alert.showAndWait();
    if (result.isPresent() && result.get() == ButtonType.OK) {
        ServiceUtilisateur su = new ServiceUtilisateur();
        su.supprimer(user.getId());
        update();
    }
});

            }
          
        };
        return cell;
    }
});
    col_nom.setCellValueFactory(new PropertyValueFactory<>("nom"));
     col_prenom.setCellValueFactory(new PropertyValueFactory<>("prenom"));
      col_email.setCellValueFactory(new PropertyValueFactory<>("email"));
       col_mdp.setCellValueFactory(new PropertyValueFactory<>("mdp"));
        col_num.setCellValueFactory(new PropertyValueFactory<>("num"));
         col_addresse.setCellValueFactory(new PropertyValueFactory<>("adresse"));
          col_type.setCellValueFactory(new PropertyValueFactory<>("type"));
         col_etat.setCellValueFactory(new PropertyValueFactory<>("etat"));
          col_img.setCellValueFactory(new PropertyValueFactory<>("img"));
           tab_user.getSelectionModel().selectedItemProperty().addListener((observable, oldValue, newValue) -> {
  
   
            Utilisateur selectedUser = newValue;
            System.out.println(selectedUser);
            FXMLLoader loader = new FXMLLoader(getClass().getResource("ModifierUser.fxml"));
            Parent root = null;
            try {
                root = loader.load();
            } catch (IOException ex) {
                Logger.getLogger(AfficherUserController.class.getName()).log(Level.SEVERE, null, ex);
            }
            ModifierUserController controller = loader.getController();
            controller.setUs(selectedUser);
            controller.setFirstInterface(this);
            Scene scene = new Scene(root);
            Stage stage = new Stage();
            stage.setScene(scene);
          stage.show();
         Stage stage1 = (Stage) add_btn.getScene().getWindow(); // get the current stage
         System.out.println(stage1);
  //  stage1.close();
    });
    }    

    @FXML
    private void Add_interface(ActionEvent event) throws IOException {
        FXMLLoader loader = new FXMLLoader(getClass().getResource("AjouterUser.fxml"));
    Parent root = loader.load();
    AjouterUserController controller = loader.getController();
            
            controller.setFirstInterface(this);
    Stage stage = new Stage();
    stage.setScene(new Scene(root));
    stage.show();
    }

  public void update(){
    ServiceUtilisateur su = new ServiceUtilisateur();
        List<Utilisateur> list= new ArrayList<>();// TODO
        list=su.getAll();
        System.out.println(list.get(0));
         ObservableList<Utilisateur> observableList = FXCollections.observableArrayList(list);
    tab_user.setItems(observableList);
  
  tab_user.refresh();
  }
      public void closeWindow() {
        Stage stage = (Stage) tab_user.getScene().getWindow();
        stage.close();
    }

    @FXML
    private void Log(ActionEvent event) throws IOException {
        FXMLLoader loader = new FXMLLoader(getClass().getResource("Logs.fxml"));
            Parent root = null;
            try {
                root = loader.load();
            } catch (IOException ex) {
                Logger.getLogger(LogsController.class.getName()).log(Level.SEVERE, null, ex);
            }
           
            Scene scene = new Scene(root);
            Stage stage = new Stage();
            stage.setScene(scene);
          stage.show();
        
    }

    @FXML
    private void Deconnect(MouseEvent event) {
          FXMLLoader loader = new FXMLLoader(getClass().getResource("Login.fxml"));
            Parent root = null;
            try {
                root = loader.load();
            } catch (IOException ex) {
                Logger.getLogger(AfficherUserController.class.getName()).log(Level.SEVERE, null, ex);
            }
       
       String fileName = "data.txt";
        String data = "";

        try {
          try (FileWriter writer = new FileWriter(fileName)) {
              writer.write(data);
              System.out.println("Data written to file.");
          }
            
        } catch (IOException e) {
            System.out.println("Error writing to file.");
        }
          
            Scene scene = new Scene(root);
            Stage stage = new Stage();
            stage.setScene(scene);
          stage.show();
          Stage stage1 = (Stage) tab_user.getScene().getWindow(); // get the current stage
         stage1.close();
    }
}
