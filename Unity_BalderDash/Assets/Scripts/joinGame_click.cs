using UnityEngine;
using UnityEngine.UI;
using System.Collections;
using System;

public class joinGame_click : MonoBehaviour {
    public GameObject ws;
    public int rnd;
    public camSript cs;
    private string datastring;
    public Text nameP;
    public Button Ubutton;
    public InputField username;
    public string uname;
    public string uid;
    private string chck;
    private float currt;
    private float rt;
    // Use this for initialization
    void Start () {
        //GameObject waitS = GameObject.FindGameObjectWithTag("waitScreen");
        //waitS.SetActive(true);
        //string theText = "true\nHow\nAre\nYou\n";
        //string[] splitString = theText.Split(new string[] {"\n"}, StringSplitOptions.None);
        rnd = 1;
        nameP.text = "Player: " + cs.userName;
        //Ubutton.GetComponent<Button>().interactable = false;
        rt = 0;
        currt = 0;
        StartCoroutine(setchck());
        

    }

    public IEnumerator setchck()
    {
        WWW www = new WWW("https://purduebalderdash.000webhostapp.com/php/getUserID.php?username=");
        yield return www;
        string wwwDataString = www.text;
        //Debug.Log("USERIDchck: " + wwwDataString);
        //cs.setID(wwwDataString);
        chck = wwwDataString;
    }


    // Update is called once per frame
    public void butpress () {
        //GameObject waitS = GameObject.FindGameObjectWithTag("waitScreen");
        //getUserID();

        //StartCoroutine(setchck());
        //Debug.Log("test1");
        StartCoroutine(jgame());
        //Debug.Log("test2");
        StartCoroutine(getGameID());

        ws.SetActive(true);

    }

    public void checkName()
    {
        uname = username.text;
        //Debug.Log("CurrUsername: " + uname);
        string lnk = "https://purduebalderdash.000webhostapp.com/php/getUserID.php?username=" + uname;
        //Debug.Log(lnk);
        StartCoroutine(getUID(lnk));
        //return uid;
         
    }

    public IEnumerator getGameID()
    {
        //Debug.Log("id passed in: " + cs.getID());
        string lnk = "https://purduebalderdash.000webhostapp.com/php/getGameID.php?userID=" + cs.getID();

        Debug.Log("linkgiven: " + lnk);
        WWW www = new WWW(lnk);
        yield return www;
        string wwwDataString = www.text;
        Debug.Log("GameID: " + wwwDataString);
        cs.gameID = wwwDataString;

    }

    public IEnumerator getUID(String lnk)
    {
        WWW www = new WWW(lnk);
        yield return www;
        string wwwDataString = www.text;
        Debug.Log("USERID: " + wwwDataString);
        cs.setID(wwwDataString);
        uid = wwwDataString;
        //Debug.Log("chck: " + chck);
        if (!uid.Equals(chck))
        {
            Ubutton.GetComponent<Button>().interactable = true;
            cs.setID(uid);
            Debug.Log("FinalID: " + cs.getUserID());
            cs.userName = uname;
            nameP.text = "Player: " + cs.userName;
        }
        else
            //Ubutton.GetComponent<Button>().interactable = false;

        if(cs.getUserID() == "1")
        {
            //Debug.Log("this is Aayush");
        }

    }

    //public IEnumerator getUserID()
    //{
    //    WWW www = new WWW("https://purduebalderdash.000webhostapp.com/php/getSessions.php?keyName=userID");
     //   yield return www;
      //  string wwwDataString = www.text;
       // Debug.Log("USERID: " + wwwDataString);
       // cs.setID(wwwDataString);
       // Debug.Log("FinalID: " + cs.getUserID());
    //}


    public int getRnd()
    {
        return rnd;
    }
    public void setRnd()
    {
        rnd ++;
    }

    

    public IEnumerator jgame()
    {
        Debug.Log("JoinGame");
        WWWForm form = new WWWForm();
        form.AddField("functionName[]", "join_game");
        form.AddField("functionName[]", cs.getID());
        //Debug.Log("JoinGame1");
        WWW www = new WWW("https://purduebalderdash.000webhostapp.com/php/gameFunctionCall.php", form);
        //Debug.Log("JoinGame1.5");
        yield return www;
        //Debug.Log("JoinGame2");
        string wwwDataString = www.text;
        Debug.Log("GID set = " + wwwDataString);
        cs.setGameID(wwwDataString);
        //Debug.Log("JoinGame3");
        //yield return www;
        //txt.text = wwwDataString;
    }
}
