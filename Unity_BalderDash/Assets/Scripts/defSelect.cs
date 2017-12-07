using UnityEngine;
using UnityEngine.UI;
using System.Collections;

public class defSelect : MonoBehaviour {

    public Text time;
    public Text def1;
    public Text def2;
    public Text def3;
    public Text def4;
    public Text def5;
    public Text def6;
    public Text scrs;

    private string selected;
    private string totsummary;
    private string[] summs;

    public Button b1;
    public Button b2;
    public Button b3;
    public Button b4;
    public Button b5;
    public Button b6;

    public GameObject rsum;
    public GameObject defs;
    public camSript jg;
    public Text rnd;

    private float tme;
    // Use this for initialization
    void Start () {

        tme = 30;

        //int rm = jg.getRnd();
        //rnd.text = "Round: " + rm + "/10";
	}
	
	// Update is called once per frame
	void Update () {
        if(tme <= 0)
        {
            tme = 0;
            rndSumI();
        }
        else
        {
            tme -= Time.deltaTime;
        }
        int dtme = (int)tme;
        time.text = "Time: " + dtme + " s";

    }

    public IEnumerator resetRound()
    {
        //Debug.Log("reseround");
        WWWForm form = new WWWForm();
        form.AddField("functionName[]", "reset_round");
        form.AddField("functionName[]", jg.getID());
        form.AddField("functionName[]", jg.getGameID());

        //Debug.Log("Js1");
        WWW www = new WWW("https://purduebalderdash.000webhostapp.com/php/gameFunctionCall.php", form);
        //Debug.Log("JoinGame1.5");
        yield return www;
        //Debug.Log("JoinGame2");
        string wwwDataString = www.text;
    }

    public void pressed1()
    {
        selected = b1.GetComponentInChildren<Text>().text;
        StartCoroutine(voteDef());
        b1.GetComponent<Button>().interactable = false;
        b2.GetComponent<Button>().interactable = false;
        b3.GetComponent<Button>().interactable = false;
        b4.GetComponent<Button>().interactable = false;
        b5.GetComponent<Button>().interactable = false;
        b6.GetComponent<Button>().interactable = false;
    }

    public void pressed2()
    {
        selected = b2.GetComponentInChildren<Text>().text;
        StartCoroutine(voteDef());
        b1.GetComponent<Button>().interactable = false;
        b2.GetComponent<Button>().interactable = false;
        b3.GetComponent<Button>().interactable = false;
        b4.GetComponent<Button>().interactable = false;
        b5.GetComponent<Button>().interactable = false;
        b6.GetComponent<Button>().interactable = false;
    }

    public void pressed3()
    {
        selected = b3.GetComponentInChildren<Text>().text;
        StartCoroutine(voteDef());
        b1.GetComponent<Button>().interactable = false;
        b2.GetComponent<Button>().interactable = false;
        b3.GetComponent<Button>().interactable = false;
        b4.GetComponent<Button>().interactable = false;
        b5.GetComponent<Button>().interactable = false;
        b6.GetComponent<Button>().interactable = false;
    }

    public void pressed4()
    {
        selected = b4.GetComponentInChildren<Text>().text;
        StartCoroutine(voteDef());
        b1.GetComponent<Button>().interactable = false;
        b2.GetComponent<Button>().interactable = false;
        b3.GetComponent<Button>().interactable = false;
        b4.GetComponent<Button>().interactable = false;
        b5.GetComponent<Button>().interactable = false;
        b6.GetComponent<Button>().interactable = false;
    }

    public void pressed5()
    {
        selected = b5.GetComponentInChildren<Text>().text;
        StartCoroutine(voteDef());
        b1.GetComponent<Button>().interactable = false;
        b2.GetComponent<Button>().interactable = false;
        b3.GetComponent<Button>().interactable = false;
        b4.GetComponent<Button>().interactable = false;
        b5.GetComponent<Button>().interactable = false;
        b6.GetComponent<Button>().interactable = false;
    }

    public void pressed6()
    {
        selected = b6.GetComponentInChildren<Text>().text;
        StartCoroutine(voteDef());
        b1.GetComponent<Button>().interactable = false;
        b2.GetComponent<Button>().interactable = false;
        b3.GetComponent<Button>().interactable = false;
        b4.GetComponent<Button>().interactable = false;
        b5.GetComponent<Button>().interactable = false;
        b6.GetComponent<Button>().interactable = false;
    }

    public IEnumerator voteDef()
    {
        //Debug.Log("Vdef");
        WWWForm form = new WWWForm();
        form.AddField("functionName[]", "select_definition");
        form.AddField("functionName[]", jg.getID());
        form.AddField("functionName[]", jg.getGameID());
        form.AddField("functionName[]", selected);
        //Debug.Log("JoinGame1");
        WWW www = new WWW("https://purduebalderdash.000webhostapp.com/php/gameFunctionCall.php", form);
        //Debug.Log("JoinGame1.5");
        yield return www;
        //Debug.Log("JoinGame2");
        string wwwDataString = www.text;
        //Debug.Log("GID set = " + wwwDataString);
        //cs.setGameID(wwwDataString);
        //Debug.Log("JoinGame3");
        //yield return www;
        //txt.text = wwwDataString;
    }


    public IEnumerator finselec()
    {
        //Debug.Log("finselect");
        WWWForm form = new WWWForm();
        form.AddField("functionName[]", "onSummary");
        form.AddField("functionName[]", jg.getID());
        form.AddField("functionName[]", jg.getGameID());
        //Debug.Log("JoinGame1");
        WWW www = new WWW("https://purduebalderdash.000webhostapp.com/php/gameFunctionCall.php", form);
        //Debug.Log("JoinGame1.5");
        yield return www;
        //Debug.Log("JoinGame2");
        string wwwDataString = www.text;
        //Debug.Log("GID set = " + wwwDataString);
        //cs.setGameID(wwwDataString);
        //Debug.Log("JoinGame3");
        //yield return www;
        //txt.text = wwwDataString;
    }

    public void loadDef()
    {
        StartCoroutine(getsum());
        def1.text = summs[0];
        def2.text = summs[1];
        def3.text = summs[2];
        def4.text = summs[3];
        if (jg.getPnum() >= 4)
            def5.text = summs[4];
        else
            def5.text = "";
        if (jg.getPnum() >= 5)
            def6.text = summs[5];
        else
            def6.text = "";

    }

    public IEnumerator getsum()
    {
        //Debug.Log("Gid passed in: " + jg.getGameID());
        string lnk = "https://purduebalderdash.000webhostapp.com/php/getSummary.php?gameID=" + jg.getGameID();
        //Debug.Log("linkgiven: " + lnk);
        WWW www = new WWW(lnk);
        yield return www;
        string wwwDataString = www.text;
        //Debug.Log("Summary: " + wwwDataString);
        totsummary = wwwDataString;
        summs = totsummary.Split('|');
    }

    public IEnumerator getscores()
    {
        //Debug.Log("Gid passed in: " + jg.getGameID());
        string lnk = "https://purduebalderdash.000webhostapp.com/php/getUsernamePoints.php?gameID=" + jg.getGameID();
        //Debug.Log("linkgiven: " + lnk);
        WWW www = new WWW(lnk);
        yield return www;
        string wwwDataString = www.text;
        jg.hardscores = wwwDataString;
        Debug.Log("Scores: " + wwwDataString);
        totsummary = wwwDataString;
        jg.scores = totsummary.Split('\n');
    }

    public void rndSumI()
    {
        GameObject defselec = GameObject.FindGameObjectWithTag("defSelect");
        //StartCoroutine(voteDef());
        int rm = jg.getRnd();
        StartCoroutine(getscores());
        rnd.text = "Round: " + rm + "/5";
        string sqrs = "Scores: ";
        for(int i = 0; i < jg.scores.Length;i++)
        {
            sqrs += jg.scores[i]+ " ";
        }
        scrs.text = sqrs;
        StartCoroutine(finselec());
        loadDef();
        
        b5.gameObject.SetActive(true);
        b6.gameObject.SetActive(true);
        b1.GetComponent<Button>().interactable = true;
        b2.GetComponent<Button>().interactable = true;
        b3.GetComponent<Button>().interactable = true;
        b4.GetComponent<Button>().interactable = true;
        b5.GetComponent<Button>().interactable = true;
        b6.GetComponent<Button>().interactable = true;
        defs.SetActive(false);

        rsum.SetActive(true);
        tme = 30;
    }
}


