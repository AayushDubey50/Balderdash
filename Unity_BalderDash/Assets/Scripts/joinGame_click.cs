using UnityEngine;
using System.Collections;

public class joinGame_click : MonoBehaviour {
    public GameObject ws;
    public int rnd;
	// Use this for initialization
	void Start () {
        //GameObject waitS = GameObject.FindGameObjectWithTag("waitScreen");
        //waitS.SetActive(true);
		Application.runInBackground = true;
        rnd = 1;
    }
	
	// Update is called once per frame
	public void butpress () {
        //GameObject waitS = GameObject.FindGameObjectWithTag("waitScreen");
		WWWForm form = new WWWForm ();
		form.AddField("functionName", "join_game");
		WWW www = new WWW ("https://purduebalderdash.000webhostapp.com/php/gameFunctionCall.php", form);
		yield return www;
		string wwwDataString = www.text;
		Debug.Log(wwwDataString);
		//txt.text = wwwDataString;
		ws.SetActive(true);


    }

    public int getRnd()
    {
        return rnd;
    }
    public void setRnd()
    {
        rnd ++;
    }
    
}
