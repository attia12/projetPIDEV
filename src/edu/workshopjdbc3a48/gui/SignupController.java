/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/javafx/FXMLController.java to edit this template
 */
package edu.workshopjdbc3a48.gui;

import edu.workshopjdbc3a48.entities.Utilisateur;
import static edu.workshopjdbc3a48.gui.Utils.mat2Image;
import edu.workshopjdbc3a48.services.EmailSender;
import edu.workshopjdbc3a48.services.ServiceUtilisateur;
import edu.workshopjdbc3a48.services.UserSession;
import java.awt.image.BufferedImage;
import java.io.File;
import java.io.IOException;
import java.net.URL;
import java.util.Random;
import java.util.ResourceBundle;
import java.util.logging.Level;
import java.util.logging.Logger;
import javafx.collections.FXCollections;
import javafx.collections.ObservableList;
import javafx.embed.swing.SwingFXUtils;
import javafx.event.ActionEvent;
import javafx.event.EventHandler;
import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.fxml.Initializable;
import javafx.geometry.Insets;
import javafx.scene.Parent;
import javafx.scene.Scene;
import javafx.scene.control.Alert;
import javafx.scene.control.Button;
import javafx.scene.control.ComboBox;
import javafx.scene.control.Label;
import javafx.scene.control.TextField;
import javafx.scene.image.ImageView;
import javafx.scene.layout.HBox;
import javafx.stage.FileChooser;
import javafx.stage.Modality;
import javafx.stage.Stage;
import javax.imageio.ImageIO;
import javax.mail.MessagingException;
import org.opencv.core.Core;
import org.opencv.core.Mat;
import org.opencv.core.MatOfRect;
import org.opencv.core.Rect;
import org.opencv.imgcodecs.Imgcodecs;
import org.opencv.objdetect.CascadeClassifier;
import org.opencv.videoio.VideoCapture;

/**
 * FXML Controller class
 *
 * @author user
 */
public class SignupController implements Initializable {
String s;
    private static final String CASCADE_CLASSIFIER_FILE = "C:\\opencv\\sources\\samples\\winrt_universal\\VideoCaptureXAML\\video_capture_xaml\\video_capture_xaml.Windows\\Assets\\haarcascade_frontalface_alt.xml";
String co;
    private CascadeClassifier faceDetector;
    private ImageView capturedImageView;
    @FXML
    private Label e_prenom;
    @FXML
    private Label e_email;
    @FXML
    private Label e_mdp;
    @FXML
    private Label e_num;
    @FXML
    private Label e_nom;
    @FXML
    private TextField tfNom_si;
    @FXML
    private TextField tfPrenom_si;
    @FXML
    private TextField tfEmail_si;
    @FXML
    private TextField tfMdp_si;
    @FXML
    private TextField tfNum_si;
    @FXML
    private TextField tfaddress_si;
    @FXML
    private Button btnAjout_si;
    @FXML
    private ComboBox<String> cbType_si;
    @FXML
    private Button btn_image_si;
    @FXML
    private Button btn_face_id;

    /**
     * Initializes the controller class.
     */
    @Override
    public void initialize(URL url, ResourceBundle rb) {
        ObservableList<String> items = FXCollections.observableArrayList( "Medecin", "Patient");
cbType_si.setItems(items); // TODO
   // TODO  // TODO
    }    

    @FXML
    private void AjoutUser(ActionEvent event) throws IOException {
     

    Utilisateur u = new Utilisateur(tfNom_si.getText(),tfPrenom_si.getText(),tfEmail_si.getText(),tfMdp_si.getText(),tfaddress_si.getText(),Integer.parseInt(tfNum_si.getText()),cbType_si.getValue(),s,0,co);
    
     System.out.println(u);
        boolean check1=true,check2=true,check3=true,check5=true,check6=true;
      if (u.getNom().matches(".*\\d+.*")==true||!Character.isUpperCase(u.getNom().charAt(0)))
      {
      check1=false;
      tfNom_si.setStyle("-fx-background-color: #ff0000;");
      if (!Character.isUpperCase(u.getNom().charAt(0)))
      e_nom.setText("* Nom doit commence par Majuscule");
      else
      {e_nom.setText("* Nom Contenir des chiffres");}
      }
     else {
       check1=true;
      tfNom_si.setStyle("-fx-background-color: #ffffff;");
      e_nom.setText("");
      
      
      
      }
      if (u.getPrenom().matches(".*\\d+.*")==true||!Character.isUpperCase(u.getPrenom().charAt(0)))
      {
      check2=false;
      tfPrenom_si.setStyle("-fx-background-color: #ff0000;");
        if (!Character.isUpperCase(u.getPrenom().charAt(0)))
      e_prenom.setText("* Prenom doit commence par Majuscule");
      else
      {e_prenom.setText("* Prenom Contenir des chiffres");}
      
      }
       else {
       check2=true;
      tfPrenom_si.setStyle("-fx-background-color: #ffffff;");
      e_prenom.setText("");
      
      
      
      }
      if (!Integer.toString(u.getNum()).matches(".*\\d+.*")==true)
      {
      check3=false;
      tfNum_si.setStyle("-fx-background-color: #ff0000;");
      }
       else {
       check3=true;
      tfNum_si.setStyle("-fx-background-color: #ffffff;");
      e_num.setText("");
      
      
      
      }
      if (u.getMdp().length()<8)
      {
      check5=false;
      tfMdp_si.setStyle("-fx-background-color: #ff0000;");
       e_mdp.setText("* Mdp doit être > 8");
      }
       else {
       check5=true;
      tfMdp_si.setStyle("-fx-background-color: #ffffff;");
      e_mdp.setText("");
      
      
      
      }
      if (u.getEmail().matches("^[\\w-\\.]+@([\\w-]+\\.)+[\\w-]{2,4}$")==false)
      {
      check6=false;
      tfEmail_si.setStyle("-fx-background-color: #ff0000;");
       e_email.setText("* Email format incorrect");
      }
       else {
       check6=true;
      tfEmail_si.setStyle("-fx-background-color: #ffffff;");
      e_email.setText("");
      
      
      
      }
     if (check1&&check2&&check3&&check5&&check6)
     {ServiceUtilisateur su = new ServiceUtilisateur();
       su.ajouter_Front(u);
      Random rand = new Random();
        int randomNumber = rand.nextInt(10000);
        u.setCode(randomNumber);
       Alert alert = new Alert(Alert.AlertType.INFORMATION);
alert.setTitle("Alerte");
alert.setHeaderText(null);
alert.setContentText("Merci de verifier votre boite E-mail pour activer votre compte !");
alert.showAndWait();
UserSession.getInstance().setCurrentUser(u);
  try {
            
            
            
    EmailSender.sendEmail(u.getEmail(), "Activation compte", "Bonjour "+u.getNom() + " " + u.getPrenom()+ " A fin d'activer votre compte merci d'utiliser ce code : "+u.getCode());
    System.out.println("Email sent successfully!");
} catch (MessagingException ex) {
    System.out.println("Failed to send email: " + ex.getMessage());
}
 FXMLLoader loader = new FXMLLoader(getClass().getResource("Verficationcompte.fxml"));
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
          Stage stage1 = (Stage) btnAjout_si.getScene().getWindow(); 
         stage1.close();
   }
     
        
    }
    

    @FXML
    private void AddImage(ActionEvent event) {
 FileChooser fileChooser = new FileChooser();
File selectedFile = fileChooser.showOpenDialog(null);
        
        s=selectedFile.toString();
        System.out.println(s);
    }

    @FXML
    private void FaceId(ActionEvent event) {
          // Create the capture window
          System.loadLibrary(Core.NATIVE_LIBRARY_NAME);

        // Load the face detector
        faceDetector = new CascadeClassifier(CASCADE_CLASSIFIER_FILE);

        Stage captureWindow = new Stage();
        
        captureWindow.initModality(Modality.APPLICATION_MODAL);
        captureWindow.setTitle("Capture Face");

        // Create the UI for the capture window
        capturedImageView = new ImageView();
        Button captureImageButton = new Button("Capture");
        captureImageButton.setOnAction(new EventHandler<ActionEvent>() {
              @Override
              public void handle(ActionEvent e) {
                  // Capture the image from the webcam
                  VideoCapture capture = new VideoCapture(0);
                  Mat image = new Mat();
                  capture.read(image);
                  
                  // Display the captured image
                  capturedImageView.setImage(mat2Image(image));
                  
//capturedImageView2.setImage(mat2Image(knownFace));
// Detect faces in the captured image
MatOfRect faceDetections = new MatOfRect();
faceDetector.detectMultiScale(image, faceDetections);

if (faceDetections.toArray().length == 0) {
    //   statusLabel.setText("No face detected");
    return;
}

// Extract the first face detected
Rect face = faceDetections.toArray()[0];
Mat faceImage = new Mat(image, face);

// Resize the face image to a standard size
// Imgproc.resize(faceImage, faceImage, new Size(IMAGE_WIDTH, IMAGE_HEIGHT));
//Imgproc.cvtColor(faceImage, faceImage, Imgproc.COLOR_BGR2GRAY);

// Compare the captured face to the known face

int codeLength = 6;
        String characters = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        Random random = new Random();

        StringBuilder code = new StringBuilder(codeLength);
        for (int i = 0; i < codeLength; i++) {
            code.append(characters.charAt(random.nextInt(characters.length())));
        }

        System.out.println("Random code: " + code.toString());
String c=code.toString();


// Release the video capture
capture.release();
File outputFile = new File("C:\\knownFaces\\"+c+".png");
co=outputFile.toString();
try {
    BufferedImage bufferedImage = SwingFXUtils.fromFXImage(mat2Image(image), null);
    ImageIO.write(bufferedImage, "png", outputFile);
} catch (IOException el) {
    el.printStackTrace();
}             }
          });

    HBox hbox = new HBox(10, capturedImageView, captureImageButton);
    hbox.setPadding(new Insets(10));

    Scene scene = new Scene(hbox);

    captureWindow.setScene(scene);
    captureWindow.show();
    }
    
}
